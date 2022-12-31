#====================================================
# Written By Don Gunasinha                          =
# Master in Data Science                            =
#====================================================

# libarary declare 

from app import app
import pandas as pd
import datetime as dt 
import numpy as np

from sqlalchemy import create_engine

from sklearn.preprocessing import MinMaxScaler
from tensorflow import keras
from keras.models import Sequential 
from keras.layers import Dense, LSTM, Dropout

from flask import Flask, jsonify, request, make_response
from flask import flash, request

from datetime import datetime, timedelta

import matplotlib.pyplot as plt

#=================================================

# Globally Declare data set 

# Data Frames 
raw_data_set=pd.DataFrame()
data_set =pd.DataFrame()
index_data_set =pd.DataFrame()
tranning_set=pd.DataFrame()
result=pd.DataFrame()

# numpy Arrays 
data_arr_x=np.array([])
data_arr_y=np.array([])
x_train = np.array([])
y_train = np.array([])
x_test = np.array([])
y_test = np.array([])
predictions  = np.array([])

# Lstm Model 
model = Sequential()
feature_length = 100

# Scaler 
scaler =  MinMaxScaler(feature_range=(0,1))


#============================================

# Support Functions definitions 


# Read data from data base and re arrange data 

def read_data_set():
  # Declare global variable 
  global data_set
  global raw_data_set
  global index_data_set

  # Define database connection 
  db_connection_str = 'mysql+pymysql://root:@localhost/csct'
  db_connection = create_engine(db_connection_str)

  # Read data in to Data Frame 
  raw_data_set = pd.read_sql('SELECT * FROM aw_product_demand', con=db_connection)


  # Validate Date
  raw_data_set['Date']= pd.to_datetime(raw_data_set['Date']).dt.date
  raw_data_set['Order_Demand'] = raw_data_set['Order_Demand'].astype('int64')

  #combine to single date
  data_set = raw_data_set.groupby('Date')['Order_Demand'].sum().reset_index()
  
  data_set.sort_values('Date', inplace=True)
  data_set['Date']=data_set['Date'].astype(str)

  # Create index data frame 
  index_data_set=data_set

  index_data_set=index_data_set.set_index(index_data_set['Date'])

  return data_set


# Function to create x and y data
def Create_Features_and_Targets(data, feature_length):
  # Declare Xand Y List 
  X = list()
  Y = list()
  for i in range(len(data) - feature_length -1):
    # create X array shift by feature length 
    X.append(data[i:(i + feature_length), 0])

    Y.append(data[i + feature_length, 0])
  # convert to numpy array format
  X = np.array(X)
  Y = np.array(Y)
  return X,Y

# function to calculate prediction 

def predict_given_date(data, date, feature_length):
  if date not in data.index:   
    data.loc[date]=0
  idx = data.index.get_loc(date)
  close_col = data.iloc[:,1:2]
  close_col = close_col.iloc[idx - feature_length : idx,:].values
  close_col = np.expand_dims(scaler.transform(close_col) , axis = 0)
  Prediction = model.predict(close_col)
  Prediction=np.array(Prediction).reshape(-1, 1)
  Prediction = scaler.inverse_transform(Prediction)
  return Prediction
# =========================== End of Function =================

#============================= Main funtion ===================
def setup():

  # Declare Global variables =================

  global data_set
  global predictions
  global result

  # Read Data from DataSet
  read_data_set()

  # Filter order Deamands array 
  data_set["Order_Demand"]=pd.to_numeric(data_set.Order_Demand,errors='coerce')
  data = data_set.iloc[:,1:2]
  data = data.values 


  data = scaler.fit_transform(data)


  X_train,y_train= Create_Features_and_Targets(data,feature_length)
  X_train = np.reshape(X_train,(X_train.shape[0],X_train.shape[1],1))

  print(X_train)

  # model
  model = Sequential([
    LSTM(100,return_sequences=True,input_shape=(X_train.shape[1],1)),
    Dropout(0.3),
    LSTM(100, return_sequences = False),
    Dropout(0.3),
      
    Dense(1),
  ])
  model.compile(optimizer='adam',loss="mean_squared_error")
  model.summary()

  # Training the model
  history = model.fit(
      X_train, 
      y_train, 
      epochs = 5, 
      batch_size = 12, 
      verbose=1,
  )

  testData = data_set.iloc[:,1:2] # Get 'Close' feature
  y_real=testData.iloc[feature_length+1:,0:].values #Actual values
  x_test = testData.iloc[:,0:].values # data to test
  # normalizing the Data using Scaler.transform function
  x_test = scaler.transform(x_test)
  x_test, y_test = Create_Features_and_Targets(x_test, feature_length)
  # Making data 3 dimensional
  x_test = np.reshape(x_test,(x_test.shape[0],x_test.shape[1],1))
  y_pred = model.predict(x_test)
  predictions=np.array(scaler.inverse_transform(y_pred)).ravel()
  result["Date"]=data_set.iloc[feature_length+1:]["Date"]
  result["Predictions"]=predictions
  result["OrderDemand"]=data_set.iloc[feature_length+1:]["Order_Demand"]

  result.plot()
  plt.show()
  print(result)
  
  #save model 
  model.save('lstm_model.h5')
  
# ====================================================================
# main function call

setup()


#====================================================================

# end points declaration 

@app.route("/products",methods=['GET'])

def category():
  global raw_data_set
  raw_data_set=raw_data_set['Product_code'].value_counts()
  return raw_data_set.to_json(orient='records')


@app.route("/validation",methods=['GET'])
def validation():
  global result
  result=result.set_index(result['Date'])
  return result.to_json(orient='records')

@app.route("/forecast_to_date",methods=["POST"])
def forecast():
  global data_set
  global scaler 
  global index_data_set
  global model

  # read incomming json data 
  data=request.get_json()
  date=data['date']
  new_date=datetime.strptime(date, "%Y-%m-%d").date()
  new_date=new_date - timedelta(days=(feature_length-1))
  new_date=new_date.strftime("%Y-%m-%d")
  print(new_date)


  result=predict_given_date(index_data_set,new_date, feature_length)
  df=pd.DataFrame()
  # df=pd.DataFrame(data=result,columns=["Prediction"])
  df['Date']=pd.date_range(start=new_date,periods=feature_length)
  df=df.loc[::-1]
  df['Prediction']=result


  df['Date']= pd.to_datetime(df['Date']).dt.date
  df.sort_values('Date', inplace=True)
  df['Date']=df['Date'].astype(str)
  df=df.set_index(df['Date'])
  df=df.tail(1)

  return df.to_json(orient='records')

@app.route("/forecast_to_range",methods=["POST"])
def forecast_to_range():
  global data_set
  global scaler 
  global index_data_set
  global model
  
  index_data_set=data_set
  
  index_data_set=index_data_set.set_index(index_data_set['Date'])
 
  # read incomming json data 
  data=request.get_json()
  date=data['date']
  new_date=datetime.strptime(date, "%Y-%m-%d").date()
  new_date=new_date - timedelta(days=(feature_length-1))
  new_date=new_date.strftime("%Y-%m-%d")

  result=predict_given_date(index_data_set,new_date, feature_length)
  df=pd.DataFrame()
  # df=pd.DataFrame(data=result,columns=["Prediction"])
  df['Date']=pd.date_range(start=new_date,periods=feature_length)
  df=df.loc[::-1]
  df['Prediction']=result
  df['Date']= pd.to_datetime(df['Date']).dt.date
  df.sort_values('Date', inplace=True)
  df['Date']=df['Date'].astype(str)
  df=df.set_index(df['Date'])
  return df.to_json(orient='records')


if __name__ == "__main__":
    app.run()
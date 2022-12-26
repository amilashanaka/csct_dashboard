# import libraries
import numpy as np
import pandas as pd
import matplotlib.pyplot as plt
import seaborn as sns
from collections import Counter
import statistics
import math

#for LSTM model
from sklearn.preprocessing import MinMaxScaler
from keras.models import Sequential
from keras.layers import Dense, LSTM, Dropout

# ignore warnings
import warnings
warnings.filterwarnings("ignore")

from datetime import datetime as dt

import pymysql
import json
from app import app

from flask import Flask, jsonify, request, make_response
from flask import flash, request

import datetime
from werkzeug.security  import generate_password_hash, check_password_hash
from functools import wraps
import requests
import numpy as np
import pandas as pd
from sklearn import linear_model
from datetime import datetime, timedelta

from statsmodels.tsa.ar_model import AR

from statsmodels.graphics.tsaplots import plot_acf, plot_pacf
import matplotlib.pyplot as plt
plt.rcParams.update({'figure.figsize':(9,7), 'figure.dpi':120})
import pmdarima as pm

from sqlalchemy import create_engine

# globally declare dataset
data_set =pd.DataFrame()

# Tranning dataset with

tranning_data_set=pd.DataFrame()

# Validation Data Set 

validate_data_set=pd.DataFrame()

# result data set 

result_data_set_tranning=pd.DataFrame()

result_data_set_forecast=pd.DataFrame()

# Lstm model 
model = Sequential()

scaler = MinMaxScaler()

train_close_len=0

# Support functions 

def read_from_db():
   
  global data_set

  db_connection_str = 'mysql+pymysql://root:@localhost/csct'
  db_connection = create_engine(db_connection_str)
  df = pd.read_sql('SELECT * FROM product__demnd', con=db_connection)
  data_set=df
  return df


def shape_input():
  global tranning_data_set
  global train_close_len
  global scaler
   # Create new data with only the "OrderDemand" column
  orderD = tranning_data_set.filter(["OrderDemand"])
  # Convert the dataframe to a np array
  orderD_array = orderD.values
  # See the train data len
  train_close_len = math.ceil(len(orderD_array) * 0.8)
  print(train_close_len)
  # Normalize the data
  
  scaled_data = scaler.fit_transform(orderD_array)
  # Create the training dataset
  train_data = scaled_data[0 : train_close_len, :]
  # Create X_train and y_train
  X_train = []
  y_train = []
  for i in range(60, len(train_data)):
      X_train.append(train_data[i - 60 : i, 0])
      y_train.append(train_data[i, 0])
      
         

  return X_train, y_train,scaled_data,orderD



 
@app.route('/setup',methods=['POST'])
def start():

  global data_set
  global tranning_data_set
  global result_data_set_tranning
  global result_data_set_forecast
  global train_close_len
  global scaler

  global model



  df=read_from_db()
  data_set

  data_set.rename(columns = {'Product_Code': 'ProductCode',
                       'Product_Category': 'ProductCategory', 
                       'Order_Demand': 'OrderDemand'}, inplace = True)



  data_set.dropna(inplace=True)

  data_set.sort_values('Date', ignore_index=True, inplace=True)


  data_set['OrderDemand'] = data_set['OrderDemand'].str.replace('(',"")
  data_set['OrderDemand'] = data_set['OrderDemand'].str.replace(')',"")
  data_set['OrderDemand'] = data_set['OrderDemand'].astype('int64')

  #Forecast the Order Demand with LSTM Model

  df = data_set[(data_set['Date']>='2012-01-01') & (data_set['Date']<='2016-12-31')].sort_values('Date', ascending=True)
  df = df.groupby('Date')['OrderDemand'].sum().reset_index()
  tranning_data_set=df

  X_train,y_train,scaled_data,orderD=shape_input()

  #  make X_train and y_train np array
  X_train, y_train = np.array(X_train), np.array(y_train)

  # reshape the data
  X_train = np.reshape(X_train, (X_train.shape[0], X_train.shape[1], 1))
 

    # create the testing dataset
  test_data = scaled_data[train_close_len - 60 : , :]
  # create X_test and y_test
  X_test = []
  y_test = df.iloc[train_close_len : , :]
  for i in range(60, len(test_data)):
      X_test.append(test_data[i - 60 : i, 0])

  # convert the test data to a np array and reshape the test data
  X_test = np.array(X_test)
  X_test = np.reshape(X_test, (X_test.shape[0], X_test.shape[1], 1))


  model.add(LSTM(units=512, return_sequences=True, activation='relu', input_shape=(X_train.shape[1], 1)))


  model.add(LSTM(units=256, activation='relu', return_sequences=False))


  model.add(Dense(128))
  
  model.add(Dense(64))

  model.add(Dense(32))

  model.add(Dense(1))


  # compile the LSTM model
  model.compile(optimizer="Adam", loss="mean_squared_error", metrics=['mae'])

  # train the LSTM model
  model.fit(X_train, y_train,
            epochs=5,
            batch_size=32, 
            verbose=1)


  # predict with LSTM model
  predictions = model.predict(X_test)
  predictions = scaler.inverse_transform(predictions)

  valid = orderD[train_close_len:]
  valid["Predictions"] = predictions

  result_data_set_tranning=df[:train_close_len]
  result_data_set_forecast=df[train_close_len:]
  result_data_set_forecast["Predictions"] = predictions


  return "Setting up completed"


start()

@app.route("/plot",methods=['GET'])
def plot():
  global result_data_set_tranning
  global result_data_set_forecast

  #visualize the data
  plt.figure(figsize=(16, 8))
  plt.title("Forecast with LSTM Model")
  plt.xlabel("Time", fontsize=14)
  plt.ylabel("Order Demand", fontsize=14)
  plt.plot(result_data_set_tranning["Date"], result_data_set_tranning["OrderDemand"])
  plt.plot(result_data_set_forecast["Date"], result_data_set_forecast["OrderDemand"], result_data_set_forecast["Predictions"])
  plt.legend(["Train", "Validation", "Predictions"], loc="lower right")
  plt.show()

  return "plot"

@app.route("/forecast",methods=["POST"])
def forecast():

  # read incomming json data 
  data=request.get_json()
  print(data)

  return "forecast"

@app.route("/category",methods=['GET'])

def category():
  global data_set
  data=data_set['ProductCategory'].value_counts()
  return data.to_json()

@app.route("/warehouse",methods=['GET'])
def warehouse():
  global data_set
  data=data_set['Warehouse'].value_counts()
  return data.to_json()


@app.route("/by_year",methods=['GET'])

def by_year():

  global data_set
  df = data_set[['OrderDemand', 'Year']].groupby(["Year"]).sum().reset_index().sort_values(by='Year', ascending=False)
  return df.to_json()

@app.route("/monthly",methods=['GET'])
def monthly():
  global data_set
  temp_data = data_set.copy()
  temp_data.Month.replace([1,2,3,4,5,6,7,8,9,10,11,12], ['Jan', 'Feb', 'Mar', 'Apr', 'May',
                                                        'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], inplace=True)
  df = temp_data[['OrderDemand',
                  'Month', 'Year',]].groupby(["Year",
                                              "Month"]).sum().reset_index().sort_values(by=['Year',
                                                                                            'Month'], ascending=False)
  df=df.T
  return df.to_json()

 
if __name__ == "__main__":
    app.run()
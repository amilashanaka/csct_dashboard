
from app import app
import pandas as pd
import datetime as dt
import numpy as np

from sqlalchemy import create_engine

from sklearn.preprocessing import MinMaxScaler
from tensorflow import keras
from keras.models import Sequential 
from keras.layers import Dense, LSTM, Dropout


import matplotlib.pyplot as plt

# Globally Declare data set 

data_set =pd.DataFrame()

tranning_set=pd.DataFrame()

test_result=pd.DataFrame()

data_arr_x=np.array([])
data_arr_y=np.array([])

x_train = np.array([])
y_train = np.array([])
x_test = np.array([])
y_test = np.array([])

test_predict  = np.array([])

train_ind =0


scaler = MinMaxScaler()


num_steps = 60

def read_data_set():
  # Declare global variable 
  global data_set
  global tranning_data_set


  # Define database connection 
  db_connection_str = 'mysql+pymysql://root:@localhost/csct'
  db_connection = create_engine(db_connection_str)

  # Read data in to Data Frame 
  data_set = pd.read_sql('SELECT * FROM product__demnd', con=db_connection)
  # Validate Date
  data_set['Date']= pd.to_datetime(data_set['Date']).dt.date
  data_set.sort_values('Date', inplace=True)
  data_set['Date']=data_set['Date'].astype(str)
 

 
  # Remove Nan values 
  

  # Clean Order Demand 

  data_set['Order_Demand'] = data_set['Order_Demand'].str.replace('(',"")
  data_set['Order_Demand'] = data_set['Order_Demand'].str.replace(')',"")
  data_set['Order_Demand'] = data_set['Order_Demand'].astype('int64')

  tranning_data_set = data_set.groupby('Date')['Order_Demand'].sum().reset_index()
  # Reset index
  data_set=data_set.set_index(data_set['Date'])
  data_set.dropna(inplace=True)
 
  return data_set


def reshape():
  global data_set
  global data_arr_x
  global data_arr_y
  global num_steps
  global tranning_data_set
  global scaler

  items=tranning_data_set.filter(['Order_Demand'])
  item_arr=np.array(items.values)
  scaled_data = scaler.fit_transform(item_arr)
  print(scaled_data)


  
  data_arr_x, data_arr_y = lstm_data_transform(scaled_data,scaled_data, num_steps=num_steps)
  print ("The new shape of x is", data_arr_x.shape)



  original_data=scaler.inverse_transform(scaled_data)
  print(original_data)

def split_data():
  global data_arr_x
  global data_arr_y
  global num_steps

  global x_train
  global y_train

  global x_test
  global y_test

  global train_ind

  train_ind = int(0.8 * len(data_arr_x))
  x_train = data_arr_x[:train_ind]
  y_train = data_arr_y[:train_ind]
  x_test = data_arr_x[train_ind:]
  y_test = data_arr_y[train_ind:]


def lstmmodel():

  
  global test_predict

  model = Sequential()

  model.add(LSTM(512, activation='relu', input_shape=(num_steps, 1), 
                return_sequences=False))
  model.add(Dense(units=256, activation='relu'))
  

  model.add(Dense(units=1, activation='relu'))
  
  
  model.compile(optimizer="Adam", loss="mean_squared_error", metrics=['mae'])
  model.fit(x_train, y_train, epochs=25)

  test_predict = model.predict(x_test)

def plot_result():

  plt.style.use('ggplot')
  plt.figure(figsize=(20, 7))
  plt.plot(y_test, label="True value")
  plt.plot(test_predict.ravel(), label="Predicted value")
  plt.legend()
  plt.show()



def lstm_data_transform(x_data, y_data, num_steps=5):
    """ Changes data to the format for LSTM training 
for sliding window approach """
    # Prepare the list for the transformed data
    X, y = list(), list()
    # Loop of the entire data set
    for i in range(x_data.shape[0]):
        # compute a new (sliding window) index
        end_ix = i + num_steps
        # if index is larger than the size of the dataset, we stop
        if end_ix >= x_data.shape[0]:
            break
        # Get a sequence of data for x
        seq_X = x_data[i:end_ix]
        # Get only the last element of the sequency for y
        seq_y = y_data[end_ix]
        # Append the list with sequencies
        X.append(seq_X)
        y.append(seq_y)
    # Make final arrays
    x_array = np.array(X)
    y_array = np.array(y)
    return x_array, y_array

@app.route('/start',methods=['GET'])
def start():
  global data_set

  print(data_set.info())

  return data_set.to_json(orient='records')

@app.route("/result_tranning",methods=['GET'])
def result_tranning():
  global test_result


  test_len=len(tranning_data_set)-len(test_predict)
  test_result=tranning_data_set[test_len:]
  test_result['Predictions']=test_predict
  test_result['OrderDemand']=y_test
  # test_result=test_result.set_index(test_result['Date'])
  return test_result.to_json(orient='records')


 
read_data_set()
reshape()
split_data()
lstmmodel()
plot_result()

if __name__ == "__main__":
    app.run()
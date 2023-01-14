# ====================================================
# Written By Don Gunasinha                          =
# Master in Data Science                            =
# ====================================================

# libarary declare

from app import app
import pandas as pd
import datetime as dt
import numpy as np
import json
import time
import math  
import sklearn.metrics  

from sqlalchemy import create_engine

from sklearn.preprocessing import MinMaxScaler
from tensorflow import keras
from keras.models import Sequential
from keras.layers import Dense, LSTM, Dropout

from statsmodels.tsa.seasonal import seasonal_decompose

from flask import Flask, jsonify, request, make_response
from flask import flash, request

from datetime import datetime, timedelta

import matplotlib.dates as mdates
import seaborn as sns
from matplotlib import pyplot
import matplotlib.pyplot as plt
from matplotlib.ticker import (MultipleLocator, FormatStrFormatter,
                               AutoMinorLocator)
import matplotlib.dates as mdates
sns.set_theme(style="darkgrid")

# =================================================

# Globally Declare data set

# Data Frames
raw_data_set = pd.DataFrame()
data_set = pd.DataFrame()
index_data_set = pd.DataFrame()
tranning_set = pd.DataFrame()
result = pd.DataFrame()
predictions_set = pd.DataFrame()
decompose_set = pd.DataFrame()
model_settings  = pd.DataFrame()

# numpy Arrays
data_arr_x = np.array([])
data_arr_y = np.array([])
x_train = np.array([])
y_train = np.array([])
x_test = np.array([])
y_test = np.array([])
predictions = np.array([])


# Initialising the LSTM model with training

model = Sequential()
feature_length =0
testing_records = 50
batch_size = 5
epochs = 10
accuracy = 0
execute_time = 0
input_units = 100
hidden_layer_1 = 67
hidden_layer_2 = 34
output_units = 1

seetings_id=0

# Scaler
scaler = MinMaxScaler()


# MySQL database connection
db_connection_str = 'mysql+pymysql://root:@localhost/csct'
db_connection = create_engine(db_connection_str)


# mesure perforemence 
rmse=0


# ============================================

# Support Functions definitions

def read_model_settings():
     global model_settings
     global feature_length
     global batch_size
     global epochs
     global input_units
     global hidden_layer_1
     global hidden_layer_2
     global output_units 
     global seetings_id

     model_settings = pd.read_sql('select * from model_settings  ORDER BY id DESC LIMIT 1', con=db_connection)
     feature_length=model_settings['feature_length'].values[0]
     batch_size=model_settings['batch_size'].values[0]
     epochs=model_settings['epochs'].values[0]
     input_units=model_settings['input_units'].values[0]
     hidden_layer_1=model_settings['hidden_layer_1'].values[0]
     hidden_layer_2=model_settings['hidden_layer_2'].values[0]
     output_units=model_settings['output_units'].values[0]
     seetings_id=model_settings['id'].values[0]

     return model_settings



# Read data from data base and re arrange data

# ---------------------------------------------
def read_data_set():
    # Declare global variable
    global data_set
    global raw_data_set
    global index_data_set
    global decompose_set

    # Read data in to Data Frame
    raw_data_set = pd.read_sql(
        'SELECT * FROM aw_product_demand', con=db_connection)

    # Validate Date
    raw_data_set['Date'] = pd.to_datetime(raw_data_set['Date']).dt.date

    raw_data_set['Order_Demand'] = raw_data_set['Order_Demand'].astype('int64')

    # combine to single date
    data_set = raw_data_set.groupby('Date')['Order_Demand'].sum().reset_index()

    data_set.sort_values('Date', inplace=True)
    data_set['Date'] = data_set['Date'].astype(str)

    # Create index data frame
    index_data_set = data_set
    index_data_set = index_data_set.set_index(index_data_set['Date'])
    index_data_set = index_data_set.drop('Date', axis=1)

    #genarate decompose data set using seasonal_decompose 

    result = seasonal_decompose(index_data_set, model='multiplicative', extrapolate_trend='freq', period=100)

    #push data in to pandas dataframe 

    decompose_set['Date'] = data_set['Date']
    decompose_set['trend'] = result.trend.values
    decompose_set['sesonal'] = result.seasonal.values
    decompose_set['resid'] = result.resid.values
    decompose_set['observed'] = result.observed.values

    return data_set


# -------------------------------------------------------------------------------
def save_tranning_history(epochs, time_steps, batch_size, execute_time, rmse,mae,mape,accurecy):
    global seetings_id

    print(seetings_id)

    id = db_connection.execute("INSERT INTO `trannings` ( `date_time`, `epochs`, `time_steps`, `batch_size`, `execute_time`, `rmse`,`mae`,`mape`,`accurecy`) VALUES ( CURRENT_TIMESTAMP, '" +
                               str(epochs)+"', '"+str(time_steps)+"', '"+str(batch_size)+"', '"+str(execute_time)+"', '"+str(rmse)+"',  '"+str(mae)+"', '"+str(mape)+"','"+str(accurecy)+"')")

    db_connection.execute("INSERT INTO `model_perforemence` ( `date_time`, `trannings_id`, `model_settings_id`) VALUES ( CURRENT_TIMESTAMP, '"+str(seetings_id)+"', '"+str(id.lastrowid)+"')")
    print("Row Added  = ", id.rowcount)



#-------------------------------------------------------------------------------

# Function to create x and y data


def input_and_targert(data, feature_length):

    # Genarate Samples
    x_samples = list()
    y_samples = list()
    NumerOfRows = len(data)

    for i in range(feature_length, NumerOfRows, 1):
        x_sample = data[i-feature_length:i]
        y_sample = data[i]
        x_samples.append(x_sample)
        y_samples.append(y_sample)

    # Reshape the input as a 3D (Number of Samples,time steps,features)
    X = np.array(x_samples)
    X = X.reshape(X.shape[0], X.shape[1], 1)
    print("\n____Input Data Shape :____")
    print(X.shape)
    # Reshape Target
    Y = np.array(y_samples)
    Y = Y.reshape(Y.shape[0], 1)
    print("\n ______Target Data Shape :______")
    print(Y.shape)

    return X, Y
# ----------------------------------------------------------------------------
# function to calculate prediction


def predict_given_date(data, date, feature_length):
    if date not in data.index:
        last_date = data.tail(1)
        data.loc[date] = 0
    idx = data.index.get_loc(date)
    # close_col = data.iloc[:,1:2]
    # close_col = close_col.iloc[idx - feature_length : idx,:].values
    # close_col = np.expand_dims(scaler.transform(close_col) , axis = 0)
    # Prediction = model.predict(close_col)
    # Prediction=np.array(Prediction).reshape(-1, 1)
    # Prediction = scaler.inverse_transform(Prediction)
    return str(last_date)


# ------------------------------------------------------------------------------

def one_step_ahade():
    global data_set
    global predictions_set
    global model

    last_values = data_set.tail(feature_length)['Order_Demand'].values
    last_values = np.array(last_values)
    print(last_values)
    last_values = scaler.transform(last_values.reshape(-1, 1))

    NumSamples = 1
    TimeSteps = feature_length
    NumFeatures = 1
    last_values = last_values.reshape(NumSamples, TimeSteps, NumFeatures)
    predicted_order_demand = model.predict(last_values)
    predicted_order_demand = scaler.inverse_transform(predicted_order_demand)
    predicted_order_demand = round(predicted_order_demand[0][0])

    last_date = str(data_set.tail(1)["Date"].values[0])
    last_date = datetime.strptime(last_date, "%Y-%m-%d")
    last_date += timedelta(days=1)
    new_date = datetime.strftime(last_date, "%Y-%m-%d")

    new_row = {'Date': new_date, 'Order_Demand': predicted_order_demand}
    data_set = data_set.append(new_row, ignore_index=True)
    predictions_set = predictions_set.append(new_row, ignore_index=True)
    print(predictions_set)

# -----------------------------------------------------------------------------


# =========================== End of support Functions =================

# ============================= Main funtion ===================
def setup():

    # Declare Global variables =================

    global data_set
    global predictions
    global result
    global scaler
    global accuracy
    global execute_time
    global rmse

    # Read Data from DataSet
    read_data_set()
    print(data_set.describe())

    # Filter order Deamands array
    data_set["Order_Demand"] = pd.to_numeric(
        data_set.Order_Demand, errors='coerce')
    data = data_set.iloc[:, 1:2]
    print(data)

    print("--------------------------------------")
    data = data.values

    ds = scaler.fit(data)
    scal_data = ds.transform(data)

    scal_data = scaler.fit_transform(data)

    x, y = input_and_targert(scal_data, feature_length)

    # Split the data into training and test
    x_train = x[:-testing_records]
    x_test = x[-testing_records:]
    y_train = y[:-testing_records]
    y_test = y[-testing_records:]

    print("\n___Tranning Data Shape___ ")
    print(x_train.shape)
    print(y_train.shape)
    print("\n___Testing Data Shape___ ")
    print(x_test.shape)
    print(y_test.shape)

    for inp, out in zip(x_train[0:2], y_train[0:2]):
        print(inp, '--', out)

    # Defining Input shapes for LSTM
    time_steps = x_train.shape[1]
    features = x_train.shape[2]
    print("Number of TimeSteps:", time_steps)
    print("Number of Features:", features)

    # Add First LSTM Layer
    model.add(LSTM(units=input_units, activation='relu', input_shape=(
        time_steps, features), return_sequences=True))

    # Adding the  Second hidden layer and the LSTM layer
    model.add(LSTM(units=hidden_layer_1, activation='relu',
              input_shape=(time_steps, features), return_sequences=True))

    # Adding the  Third hidden layer and the LSTM layer
    model.add(LSTM(units=hidden_layer_2,
              activation='relu', return_sequences=False))

    # Adding the output layer
    model.add(Dense(units=output_units))
    # Compiling model
    model.compile(optimizer='adam', loss='mean_squared_error')

    print(model.input)
    print(model.output)

    print(model.summary())

    # Measuring the time taken by the model to train
    start_time = time.time()

    # Fitting the RNN to the Training set
    model_history = model.fit(x_train, y_train, batch_size, epochs)

    end_time = time.time()
    execute_time = round((end_time-start_time)/60, 2)
    print("__Total Time Taken: ", execute_time, '   Minutes___')

    # Making predictions on test data
    predicted = model.predict(x_test)
    predicted = scaler.inverse_transform(predicted)

    # Getting the original price values for testing data
    orig = y_test
    orig = scaler.inverse_transform(y_test)

    # Accuracy of the predictions
    accuracy = 100 - (100*(abs(orig-predicted)/orig)).mean()

    mse = sklearn.metrics.mean_squared_error(orig, predicted) 
    rmse=math.sqrt(mse)
    mae=sklearn.metrics.mean_absolute_error(orig, predicted)
    mape=sklearn.metrics.mean_absolute_percentage_error(orig, predicted)
    mape=mape
    mape=round(mape,2)
 

    accuracy = round(accuracy, 2)
    print('Accuracy:', accuracy)

    save_tranning_history(epochs, time_steps, batch_size,
                          execute_time, rmse,mae,mape,accuracy)

    # Generating predictions on full data
    TrainPredictions = scaler.inverse_transform(model.predict(x_train))
    TestPredictions = scaler.inverse_transform(model.predict(x_test))
    FullDataPredictions = np.append(TrainPredictions, TestPredictions)

    # Save data to result data set

    result["Date"] = data_set.iloc[time_steps:]["Date"]
    result["Predictions"] = FullDataPredictions
    result["OrderDemand"] = data[time_steps:]

# ====================================================================
# main function call

read_model_settings()


setup()


# ====================================================================

# end points declaration

@app.route("/plot_result", methods=['GET'])
def plot_result():

    # plotting the full data
    plt.plot(result["Predictions"], color='blue',
             label='Predicted Order Demand')
    plt.plot(result["OrderDemand"], color='lightblue', label='Original Price')
    plt.title('Order Demand Predictions')
    plt.xlabel(' Date')
    plt.ylabel('Order Demand')
    plt.legend()
    fig = plt.gcf()
    fig.set_figwidth(20)
    fig.set_figheight(8)
    plt.show()

    return "plot complete"


@app.route('/decompose', methods=['GET'])
def decompose():
    return decompose_set.to_json(orient='records')


@app.route('/decompose_plot_resid', methods=['GET'])
def decompose_plot():
    result = seasonal_decompose(
        index_data_set, model='multiplicative', extrapolate_trend='freq', period=100)

    ax = sns.lineplot(data=result.resid)

    ax.xaxis.set_major_locator(mdates.DayLocator(interval=30))
    plt.gcf().autofmt_xdate()

    plt.show()
    return decompose_set.to_json(orient='records')


@app.route("/predict_one_step", methods=['GET'])
def predict_one_step():
    one_step_ahade()
    steps = str(len(predictions_set))
    return steps


@app.route("/predict_result", methods=['GET'])
def predicpredict_result():
    global predictions_set
    return predictions_set.to_json(orient='records')


@app.route("/plot_order-demands", methods=['GET'])
def plot_order_demands_total():
    global raw_data_set
    sns.lineplot(x='Date', y='Order_Demand',
                 hue='Warehouse', data=raw_data_set)
    plt.figure(figsize=(20, 7))
    plt.xticks(rotation=15)
    plt.gcf().autofmt_xdate()

    plt.legend()
    plt.show()

    return "Order demand"


@app.route("/plot_order_demand_total", methods=['GET'])
def plot_order_demands():
    global data_set

    dtFmt = mdates.DateFormatter('%Y-%b')  # define the formatting

    sns.lineplot(x='Date', y='Order_Demand', data=data_set)
    plt.figure(figsize=(20, 7))
    plt.gca().xaxis.set_major_formatter(dtFmt)
    # show every 12th tick on x axes
    plt.gca().xaxis.set_major_locator(mdates.MonthLocator(interval=1))
    plt.xticks(rotation=90, fontweight='light',  fontsize='x-small',)
    plt.legend()
    plt.show()

    return "Order demand"


@app.route("/products", methods=['GET'])
def products():
    global raw_data_set
    result_array = raw_data_set['Product_code'].unique()
    return result_array.tolist()


@app.route("/date_range", methods=['GET'])
def date_range():

    result_array = data_set['Date'].unique()
    return result_array.tolist()


@app.route("/warehouse", methods=['GET'])
def warehouse():
    global raw_data_set
    warehouse_array = raw_data_set['Warehouse'].unique()
    return warehouse_array.tolist()


@app.route("/row_data", methods=['GET'])
def row_data():
    global raw_data_set
    return raw_data_set.to_json(orient='records')


@app.route("/forecast_data", methods=['GET'])
def validation():
    global result
    result = result.set_index(result['Date'])
    return result.to_json(orient='records')


@app.route("/forecast_to_date", methods=["POST"])
def forecast_to_date():
    global data_set
    global scaler
    global index_data_set
    global model

    # read incomming json data
    data = request.get_json()
    date = data['date']
    new_date = datetime.strptime(date, "%Y-%m-%d").date()
    new_date = new_date - timedelta(days=(feature_length-1))
    new_date = new_date.strftime("%Y-%m-%d")
    print(new_date)

    result = predict_given_date(index_data_set, new_date, feature_length)
    # df=pd.DataFrame()
    # # df=pd.DataFrame(data=result,columns=["Prediction"])
    # df['Date']=pd.date_range(start=new_date,periods=feature_length)
    # df=df.loc[::-1]
    # df['Prediction']=result

    # df['Date']= pd.to_datetime(df['Date']).dt.date
    # df.sort_values('Date', inplace=True)
    # df['Date']=df['Date'].astype(str)
    # df=df.set_index(df['Date'])
    # df=df.tail(1)

    return result


@app.route("/forecast_to_range", methods=["POST"])
def forecast_to_range():
    global data_set
    global scaler
    global index_data_set
    global model

    index_data_set = data_set

    index_data_set = index_data_set.set_index(index_data_set['Date'])

    # read incomming json data
    data = request.get_json()
    date = data['date']
    new_date = datetime.strptime(date, "%Y-%m-%d").date()
    new_date = new_date - timedelta(days=(feature_length-1))
    new_date = new_date.strftime("%Y-%m-%d")

    result = predict_given_date(index_data_set, new_date, feature_length)
    df = pd.DataFrame()
    # df=pd.DataFrame(data=result,columns=["Prediction"])
    df['Date'] = pd.date_range(start=new_date, periods=feature_length)
    df = df.loc[::-1]
    df['Prediction'] = result
    df['Date'] = pd.to_datetime(df['Date']).dt.date
    df.sort_values('Date', inplace=True)
    df['Date'] = df['Date'].astype(str)
    df = df.set_index(df['Date'])
    return df.to_json(orient='records')


if __name__ == "__main__":
    app.run()

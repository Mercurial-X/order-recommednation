# EDA
import pandas as pd
import numpy as np

# Data Preprocessing 
from sklearn import preprocessing

# Data visualisation
import matplotlib.pyplot as plt
import seaborn as sns
sns.set()

# Recommender System Imps
# Content Based Filtering 
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import linear_kernel
from sklearn.feature_extraction.text import CountVectorizer
from sklearn.metrics.pairwise import cosine_similarity
# Collaborative Based Filtering 
from scipy.sparse import csr_matrix
from sklearn.neighbors import NearestNeighbors

# To work with text data 
import re
import string

df = pd.read_csv('C:\\xampp\\htdocs\\HTB\\archive\\data.csv')
df.head()

len(list(df['Name'].unique()))

df['C_Type'].unique() # Categorical Data 

df['Veg_Non'].unique() # Categorical Data 

len(df) 

df.shape

df.info()

# Let's make a function to remove all the punctuation from the "Describe" column
def text_cleaning(text):
    text  = "".join([char for char in text if char not in string.punctuation])    
    return text


# Let's clean the text 
df['Describe'] = df['Describe'].apply(text_cleaning)


# Let's see if that worked...
df.head()

# Are there any duplicate data ?
df.duplicated().sum()
# None :)

# Are there any null values?
df.isnull().sum()
# None :))

# General Description 
df.describe()

tfidf = TfidfVectorizer(stop_words='english')
tfidf_matrix = tfidf.fit_transform(df['Describe'])
tfidf_matrix.shape

cosine_sim = linear_kernel(tfidf_matrix, tfidf_matrix)
cosine_sim

# Just considering the Food names from the dataframe
indices = pd.Series(df.index, index=df['Name']).drop_duplicates()
indices

# The main recommender code!
def get_recommendations(title, cosine_sim=cosine_sim):
    
    idx = indices[title]
    sim_scores = list(enumerate(cosine_sim[idx]))
    sim_scores = sorted(sim_scores, key=lambda x: x[1], reverse=True)

    # Get the scores of the 5 most similar food
    sim_scores = sim_scores[1:6]
    
    food_indices = [i[0] for i in sim_scores]
    return df['Name'].iloc[food_indices]

# Including all features that will help in recommending better
features = ['C_Type','Veg_Non', 'Describe']

# Soup represents a mixture of elements 
# Similarly, I am making one column that will have all the important features 
# I am simply concatenating the strings 

def create_soup(x):
    return x['C_Type'] + " " + x['Veg_Non'] + " " + x['Describe']

# Using the soup(), I am creating the column for the dataframe df
df['soup'] = df.apply(create_soup, axis=1)

# Checking out if that worked!
df.head()

count = CountVectorizer(stop_words='english')
count_matrix = count.fit_transform(df['soup'])

cosine_sim2 = cosine_similarity(count_matrix, count_matrix)

# Reseting the index and pulling out the names of the food alone from the df dataframe
df = df.reset_index()
indices = pd.Series(df.index, index=df['Name'])

# Let's see the names of the food pulled out
display(indices)

# This is the first model - simple variation 
get_recommendations('tricolour salad')

# This is the second model - advanced variation 
get_recommendations('tricolour salad', cosine_sim2)

# Importing the ratings file
rating = pd.read_csv('C:\\xampp\\htdocs\\HTB\\archive\\ratings.csv')
rating.head()

rating.shape

rating.isnull().sum()

# I actually saw the data earlier and found that the last row had no values 
# Let's see 
rating.tail()

# Removing the last row 
rating = rating[:511]
rating.tail()

# So, now there should not be any null value 
rating.isnull().sum()

# Making a dataframe that has food ID and the number of ratings
food_rating = rating.groupby(by = 'Food_ID').count()
food_rating = food_rating['Rating'].reset_index().rename(columns={'Rating':'Rating_count'})
food_rating

# Food rating dataframe description
food_rating['Rating_count'].describe()

# The user rating dataframe shows the number of ratings given with respect to the user
user_rating = rating.groupby(by='User_ID').count()
user_rating = user_rating['Rating'].reset_index().rename(columns={'Rating':'Rating_count'})
user_rating

# User rating dataframe description 
user_rating["Rating_count"].describe()

# Ultimate Table
rating_matrix = rating.pivot_table(index='Food_ID',columns='User_ID',values='Rating').fillna(0)
rating_matrix.head()

# Shape of rating_matrix
rating_matrix.shape

csr_rating_matrix =  csr_matrix(rating_matrix.values)
print(csr_rating_matrix)

# Using cosine similarity to find nearest neigbours 
recommender = NearestNeighbors(metric='cosine')
recommender.fit(csr_rating_matrix)

# The main recommender code!
def Get_Recommendations(title):
    user= df[df['Name']==title]
    user_index = np.where(rating_matrix.index==int(user['Food_ID']))[0][0]
    user_ratings = rating_matrix.iloc[user_index]

    reshaped = user_ratings.values.reshape(1,-1)
    distances, indices = recommender.kneighbors(reshaped,n_neighbors=16)
    
    nearest_neighbors_indices = rating_matrix.iloc[indices[0]].index[1:]
    nearest_neighbors = pd.DataFrame({'Food_ID': nearest_neighbors_indices})
    
    result = pd.merge(nearest_neighbors,df,on='Food_ID',how='left')
    
    return result.head()

# Get recommendations with this function 
Get_Recommendations('tricolour salad')
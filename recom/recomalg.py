import sys
import pandas as pd
import numpy as np
from scipy.sparse import csr_matrix
from sklearn.neighbors import NearestNeighbors

food = pd.read_csv('C:\\xampp\\htdocs\\HTB\\archive\\data.csv')
ratings = pd.read_csv('C:\\xampp\\htdocs\\HTB\\archive\\ratings.csv')

dataset = ratings.pivot_table(index='Food_ID', columns='User_ID', values='Rating')
dataset.fillna(0, inplace=True)







# Food recommendation system
def food_recommendation(Food_Name):
    n = 10
    FoodList = food[food['Name'].str.contains(Food_Name)]
    if len(FoodList):
        Foodi = FoodList.iloc[0]['Food_ID']
        Foodi = dataset[dataset['Food_ID'] == Foodi].index[0]

        csr_data = csr_matrix(dataset.values)
        
        model = NearestNeighbors(metric='cosine', algorithm='brute', n_neighbors=n+1, n_jobs=-1)
        model.fit(csr_data)

        distances, indices = model.kneighbors(csr_data[Foodi], n_neighbors=n+1)
        Food_indices = sorted(list(zip(indices.squeeze().tolist(), distances.squeeze().tolist())), key=lambda x: x[1])
        
        Recommendations = []
        for val in Food_indices:
            if val[0] != Foodi:
                Foodi = dataset.iloc[val[0]]['Food_ID']
                i = food[food['Food_ID'] == Foodi].index
                Recommendations.append({'Name': food.iloc[i]['Name'].values[0], 'Distance': val[1]})
        
        df = pd.DataFrame(Recommendations, index=range(1, n+1))
        return df['Name']
    else:
        return []








# Remove sparsity
csr_dataset = csr_matrix(dataset.values)
dataset.reset_index(inplace=True)












# Using algorithm


model = NearestNeighbors(metric='cosine', algorithm='brute', n_neighbors=20, n_jobs=-1)
model.fit(csr_dataset)











# Get the food name from command-line argument
food_name = sys.argv[1]

# Get the recommendations
recommendations = food_recommendation(food_name)

# Print the recommendations
for recommendation in recommendations:
    print(recommendation)

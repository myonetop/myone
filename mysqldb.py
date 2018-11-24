#python -m pip install mysql-connector
import mysql.connector
import json

dbhost = "localhost"
dbuser = "root"
dbpass = ""

mydb = mysql.connector.connect(
  host=dbhost,
  user=dbuser,
  passwd=dbpass
)

mycursor = mydb.cursor()

mycursor.execute("SHOW DATABASES")

dbcounter = 0

for x in mycursor:
  if x[0] == "instagram_mute":
    dbcounter += 1

if dbcounter == 0:
    mycursor.execute("CREATE DATABASE instagram_mute")

mydb = mysql.connector.connect(
  host=dbhost,
  user=dbuser,
  passwd=dbpass,
  database="instagram_mute"
)

mycursor = mydb.cursor()

mycursor.execute("SHOW TABLES")

tbcounter = 0

for x in mycursor:
  if x[0] == "mute":
    tbcounter += 1
    
if tbcounter > 0:    
    mycursor.execute("DROP TABLE mute")

mycursor.execute("CREATE TABLE mute (username VARCHAR(255), multlist LONGTEXT)")

mycursor.execute("ALTER TABLE mute ADD COLUMN id INT AUTO_INCREMENT PRIMARY KEY")

mycursor.execute("SHOW TABLES")

mydb = mysql.connector.connect(
  host=dbhost,
  user=dbuser,
  passwd=dbpass,
  database="instagram_mute"
)

mycursor = mydb.cursor()

with open('mute.json') as data_file:    
    data = json.load(data_file)

counter = 0

while counter < len(data["mute"]):

    sql = "INSERT INTO mute (username, multlist) VALUES (%s, %s)"

    val = (data["mute"][counter]["username"], data["mute"][counter]["multlist"])
    
    mycursor.execute(sql, val)

    mydb.commit()

    counter = counter + 1

sql = "SELECT * FROM mute"

mycursor.execute(sql)

myresult = mycursor.fetchall()

for x in myresult:
  print(x)
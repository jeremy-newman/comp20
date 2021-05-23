const MongoClient = require('mongodb').MongoClient;
const url = "mongodb+srv://jeremy_newman:fence23456@cluster0.bieyf.mongodb.net/myFirstDatabase?retryWrites=true&w=majority"

  MongoClient.connect(url, { useUnifiedTopology: true }, function(err, db) {
  if(err) { return console.log(err); return;}
  
    var dbo = db.db("stock_ticker");
	var collection = dbo.collection('companies');
	
	console.log("Success!");
	db.close();
 
});
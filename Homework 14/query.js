var http = require("http");
var fs = require("fs");
var qs = require("querystring");


const MongoClient = require('mongodb').MongoClient;
const url = "mongodb+srv://jeremy_newman:fence23456@cluster0.bieyf.mongodb.net/myFirstDatabase?retryWrites=true&w=majority"

  MongoClient.connect(url, { useUnifiedTopology: true }, function(err, db) {
  if(err) { return console.log(err); return;}
  //var port = 8080
  var port = process.env.PORT || 3000; //this is the port for Heroku
  
  //creates the server
  http.createServer(function (req, res) 
    {
  	  
  	  if (req.url == "/")
  	  {
  		  file = 'index.html';
  		  fs.readFile(file, function(err, txt) {
      	  res.writeHead(200, {'Content-Type': 'text/html'});
            res.write(txt);
            res.end();
  		  });
  	  }
  	  else if (req.url == "/process")
  	  {
  		 res.writeHead(200, {'Content-Type':'text/html'});
  		 pdata = "";
  		 req.on('data', data => {
             pdata += data.toString();
           });
  
  		// when complete POST data is received
  		req.on('end', () => {
  			pdata = qs.parse(pdata);
            //database
            var dbo = db.db("stock_ticker");
            
            //if the radio button is on ticker
            if (pdata["c_or_t"] == "ticker") {
                res.write("Input ticker symbol: " + pdata["text"] + "<br>");
                //query on the ticker
                var query = ({"ticker": pdata["text"]});
                var filter = {projection: {"name": 1, "ticker": 1, "_id":0}};
                dbo.collection("companies").find(query, filter).toArray(function(err, result) {
                    if (err) {
                        res.write("Please input a valid ticker symbol.");
                        throw err;
                    }
                    //write out all of the company names that correspond to
                    //the provided ticker
                    for (var i = 0; i < result.length; i++) {
                        res.write("Company Name: " + result[i]["name"] + "<br>");
                    }
                    res.end();
                });
            }
            //if the radio button is on company name
            else if (pdata["c_or_t"] == "company") {
                res.write("Input company name: " + pdata["text"] + "<br>");
                //query on ther company name
                var query = ({"name": pdata["text"]});
                var filter = {projection: {"name": 1, "ticker": 1, "_id":0}};
                dbo.collection("companies").find(query, filter).toArray(function(err, result) {
                    if (err) {
                        res.write("Please input a valid company name.");
                        throw err;
                    }
                    //write out the ticker name that correspond to the provided
                    //company name
                    res.write("Ticker Symbol: " + result[0]["ticker"]);
                    res.end();
                });
            }
  		});
  	  }
  	  else 
  	  {
  		  res.writeHead(200, {'Content-Type':'text/html'});
  		  res.write ("Unknown page request");
  		  res.end();
  	  }
  }).listen(port);
});
const MongoClient = require('mongodb').MongoClient;
const url = "mongodb+srv://jeremy_newman:fence23456@cluster0.bieyf.mongodb.net/myFirstDatabase?retryWrites=true&w=majority"

var companies = [];
var tickers = [];

var fs = require("fs");
file = "companies.csv";
fs.readFile(file, "utf8", function(err, txt) {
    //split the line by end lines to create array
    var split_by_line = txt.split("\n");
    //go through each of the items in the array and split by comma to create
    //new arrays
    for (var i = 0; i < split_by_line.length; i++) {
        var split_by_comma = split_by_line[i].split(",");
        //append first half to companies array
        companies[i] = split_by_comma[0];
        //append second half to tickers array after slicing off
        //the new line character
        tickers[i] = split_by_comma[1].slice(0, -1);
    }
    console.log(txt);
    console.log(companies[2]);
    console.log(tickers[2]);
});

function main() {
    MongoClient.connect(url, {useUnifiedTopology: true}, function(err, db) {
        if(err) {
            return console.log(err);
            return;
        }
        var dbo = db.db("stock_ticker");
        var collection = dbo.collection("companies");
        //for each of the companies/tickers
        for (var i = 1; i < companies.length; i++) {
            //set up the entry
            var entry = {"name": companies[i], "ticker": tickers[i]};
            //insert that entry into the database
            collection.insertOne(entry, function(err, res) {
                if (err) {
                    console.log("query err: " + err);
                    return;
                }
                console.log("new document inserted");
            });
        }
        console.log("Success!");
    });
}

main();
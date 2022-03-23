const request = require("request");
const cheerio = require("cheerio");

const url = 'https://faith.tw/sub.php?main=1&sub=1#main'
request(url, (err, res, body) => {
  console.log(res)
})

var data = {
   var1:"something",
   var2:"something else"
};
var querystring = require("querystring");
var qs = querystring.stringify(data);
var qslength = qs.length;
var options = {
    hostname: "faith.tw",
    port: 80,
    path: "/admin/shopee_detail.php",
    method: 'POST',
    headers:{
        'Content-Type': 'application/x-www-form-urlencoded',
        'Content-Length': qslength
    }
};

var http = require('http');
var buffer = "";
var req = http.request(options, function(res) {
    res.on('data', function (chunk) {
       buffer+=chunk;
    });
    res.on('end', function() {
        console.log(buffer);
    });
});

req.write(qs);
req.end();
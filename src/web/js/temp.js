var http = require('http');
var fs = require('fs');
var path = require('path');
var querystring = require('querystring');

http.createServer(function (req, res) {

    if (req.url === "/") {
        fs.readFile("src/web/html/introduction.html", "UTF-8", function (err, html) {
            res.writeHead(200, { "Content-Type": "text/html" });
            res.end(html);
        });
    } else if (req.url === "/introduction.html") {
        fs.readFile("src/web/html/introduction.html", "UTF-8", function (err, html) {
            res.writeHead(200, { "Content-Type": "text/html" });
            res.end(html);
        });
    } else if (req.url === "/spot.html") {
        fs.readFile("src/web/html/spot.html", "UTF-8", function (err, html) {
            res.writeHead(200, { "Content-Type": "text/html" });
            res.end(html);
        });
    } else if (req.url === "/map.html") {
        fs.readFile("src/web/html/map.html", "UTF-8", function (err, html) {
            res.writeHead(200, { "Content-Type": "text/html" });
            res.end(html);
        });
    } else if (req.url === "/donation.html") {
        if (req.method === "GET") {
            fs.readFile("src/web/html/donation.html", "UTF-8", function (err, html) {
                res.writeHead(200, { "Content-Type": "text/html" });
                res.end(html);
            });
        }
        else if (req.method === "POST") {
            var body = "";
            req.on("data", function (chunk) {
                body += chunk;
            });

            req.on("end", function () {
                body = querystring.parse(body);

                res.writeHead(200, { 'Content-Type': 'text/html; charset=utf8' });

                if (body.name && body.money) {
                    res.write("感謝" + body.name + "為老人們捐的" + body.money);
                } else {
                    res.write(postHTML);
                }
                res.end();
            });

        }
    } else if (req.url === "/login.html") {
        if (req.method === "GET") {
            fs.readFile("src/web/html/login.html", "UTF-8", function (err, html) {
                res.writeHead(200, { "Content-Type": "text/html" });
                res.end(html);
            });
        }
        else if (req.method === "POST") {
            var body = "";
            req.on("data", function (chunk) {
                body += chunk;
            });

            req.on("end", function () {
                body = querystring.parse(body);

                res.writeHead(200, { 'Content-Type': 'text/html; charset=utf8' });

                if (body.name && body.password) {
                    res.write("信箱:" + body.name + "<br>密碼:" + body.password);
                } else {
                    res.write(postHTML);
                }
                res.end();
            });

        }
    } else if (req.url === "/catch.html") {
        fs.readFile("src/web/html/catch.html", "UTF-8", function (err, html) {
            res.writeHead(200, { "Content-Type": "text/html" });
            res.end(html);
        });
    }else if(req.url === "/exchange") {
        if(req.method === "GET"){
            fs.readFile("src/web/html/exchange.html", "UTF-8", function (err, html) {
                res.writeHead(200, { "Content-Type": "text/html" });
                res.end(html);
            });
        }
        else if(req.method === "POST"){
            var body = "";
            req.on("data", function (chunk) {
                body += chunk;
            });
            
            req.on("end", function () {
                body = querystring.parse(body);
                
                res.writeHead(200, { 'Content-Type': 'text/html; charset=utf8' });

                if (body.user && body.address) { 
                    res.write("感謝" + body.user + "的參與,獎章將會送至" + body.address);
                } else { 
                    res.write(postHTML);
                }
                res.end();
            });
            
        }
    } 
    
    
    else if (req.url.match("\.css$")) {
        var cssPath = path.join(path.resolve('./'), 'src/web', req.url);
        
        var fileStream = fs.createReadStream(cssPath, "UTF-8");
        res.writeHead(200, { "Content-Type": "text/css" });
        fileStream.pipe(res);
        
    } else if (req.url.match("\.jpg$")) {
        var imagePath = path.join(path.resolve('./'), 'src/web', req.url);
        
        var fileStream = fs.createReadStream(imagePath);
        res.writeHead(200, { "Content-Type": "image/jpg" });
        fileStream.pipe(res);
    } else if (req.url.match("\.gif$")) {
        var imagePath = path.join(path.resolve('./'), 'src/web', req.url);
        
        var fileStream = fs.createReadStream(imagePath);
        res.writeHead(200, { "Content-Type": "image/gif" });
        fileStream.pipe(res);
    } else {
        res.writeHead(404, { "Content-Type": "text/html" });
        res.end("No Page Found");
    }

}).listen(3000);
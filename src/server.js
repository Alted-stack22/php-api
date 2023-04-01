const express = require("express");
const bodyParser = require("body-parser");
const router = express.Router();

var app = express();
app.use(bodyParser.json());
app.use(router);

const books = [
    {
        'title': 'The art of war',
        'author_id': 2,
        'genre_id': 2
    },
    {
        'title': 'The Iliad',
        'author_id': 1,
        'genre_id': 1
    },
    {
        'title': 'War and peace',
        'author_id': 3,
        'genre_id': 1
    }
];

router.get("/", (req, res) => {
    console.log("Query", req.query);
    console.log("Body", req.body);
    res.json(books);
});

var port = 8000;
app.listen(port, () => {
    console.log("Listening on http://localhost:" + port + " ...");
});

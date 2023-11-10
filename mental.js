const express = require("express");
const fs = require("fs");
const app = express();
const port = 3000;

app.use(express.json());

app.post("/your-server-endpoint", (req, res) => {
    const userData = req.body;

    // Read the existing data from userdata.txt
    fs.readFile("userdata.txt", "utf8", (err, data) => {
        if (err) {
            console.error(err);
            res.status(500).json({ error: "Internal server error" });
            return;
        }

        const userDataArray = JSON.parse(data);

        // Check if email, date, and time already exist
        const emailExists = userDataArray.some(entry => entry.email === userData.email);
        const dateOrTimeExists = userDataArray.some(entry => entry.date === userData.date && entry.time === userData.time);

        if (emailExists) {
            res.json({ emailExists: true });
        } else if (dateOrTimeExists) {
            res.json({ dateOrTimeExists: true });
        } else {
            // Data is valid, add it to the array and save it to the file
            userDataArray.push(userData);
            fs.writeFile("userdata.txt", JSON.stringify(userDataArray, null, 2), err => {
                if (err) {
                    console.error(err);
                    res.status(500).json({ error: "Internal server error" });
                } else {
                    res.json({ success: true });
                }
            });
        }
    });
});

app.listen(port, () => {
    console.log(`Server is running on port ${port}`);
});
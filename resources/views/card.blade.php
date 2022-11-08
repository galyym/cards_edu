<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cards</title>
</head>
<body>
    <form action="/api/card" id="card" method="post"></form>
    <label for="">RFID номер</label>
    <input id="rfid" type="text" name="rfid" value=""  form="card" readonly>
    <label for="">QR код</label>
    <input id="qr" type="text" name="qr_code" form="card" readonly>
    <label for="">Номер карты</label>
    <input id="num" type="text" name="card_number" form="card" readonly>
    <label for="">NFC</label>
    <input id="nfc" type="text" name="nfc" form="card" readonly>

    <input type="text" id="temp" style="opacity: 0">

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        let arr = ["qr", "num", "nfc"]
        let interval = setInterval(() => {
            axios.get("http://192.168.31.11:8400/tablerfid:5102:com3")
                .then(response => {
                    clearInterval(interval)
                    console.log(response.data)
                    document.getElementById("rfid").value = response.data
                    cycle()
                })
                .catch(error => {
                    console.log()
                })
        }, 2000)

        function cycle(){
            document.getElementById("temp").focus()
            document.getElementById("temp")
                .addEventListener("keyup", function(event) {
                    event.preventDefault();
                    if (event.keyCode === 13) {
                        var element_id = arr.shift()
                        let temp = document.getElementById("temp").value;
                        document.getElementById(element_id).value = temp
                        document.getElementById("temp").value = ""
                        if(arr.length === 0){
                             document.getElementById("card").submit();
                        }
                    }
                });
        }


    </script>
</body>
</html>

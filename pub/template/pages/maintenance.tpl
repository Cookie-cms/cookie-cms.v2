<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 Service Unavailable</title>
    <style>
        body {
            background: #222222;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            font-family: 'Trebuchet MS', sans-serif;
            padding: 10% 10% 10% 10%;
        }

        #image {
            width: inherit;
            border: 3px solid white;
        }

        .box {
            width: 240px;
            float: left;
            margin: 3px;
            padding: 3px;
        }

        h2, h1, h3 {
            font-weight: bolder;
            color: white;
            margin-block-start: 0.12em;
            margin-block-end: 0em;
        }
        
    </style>
</head>
<body>
    <div class="box">
        <img id="image" src="https://i0.wp.com/www.live-evil.org/wp-content/uploads/2022/06/sleepy.gif" alt="">
    </div>
    <h1>503</h1>
    <h2>Service on Maintenance</h2>
    <h3>{{ reason }}</h3>
    <h3>{{ time }}</h3>
</body>
</html>
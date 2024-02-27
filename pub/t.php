<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Example</title>
</head>
<body>

<script>
const publicKey = {
  challenge: new Uint8Array([117, 61, 252, 231, 191, 241]),
  rp: { id: "acme.com", name: "ACME Corporation" },
  user: {
    id: new Uint8Array([79, 252, 83, 72, 214, 7, 89, 26]),
    name: "jamiedoe",
    displayName: "Jamie Doe"
  },
  pubKeyCredParams: [ {type: "public-key", alg: -7} ]
}

navigator.credentials.create({ publicKey })


</script>

</body>
</html>

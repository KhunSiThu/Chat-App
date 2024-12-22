<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chat</title>

    <link rel="icon" href="./images/chat.png" type="image/png">

    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <link rel="stylesheet" href="../../Resources/CSS/output.css">

    <link rel="stylesheet" href="../../Resources/CSS/app.css">
    <link rel="stylesheet" href="../../Resources/CSS/mobile.css">

    <style>
        #chatBox {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 500;

            display: flex;
            align-items: center;

            span {
                margin-right: 10px;
                display: none;
                transition: 0.7s;
            }

            svg {
                border-radius: 50%;
                background-color: var(--color-white);
                padding: 10px;
                color: var(--color-primary);
            }
        }

        #chatBox:hover span {
            display: block;
        }
    </style>

</head>

<body>


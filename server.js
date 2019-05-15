require('dotenv').config();
var app = require('http').createServer();
var io = require('socket.io')(app);

const nodemailer = require('nodemailer');

let transporter = nodemailer.createTransport({
    service: 'gmail',
    auth: {
        user: process.env.MAIL_USERNAME,
        pass: process.env.MAIL_PASSWORD,
    }
});
let mailOptionsDiretorUO = {
    from: "estg@gmail.com",
    to: "2151571@my.ipleiria.pt",
    subject: "Nova Proposta na plataforma de contratações",
    text: "Caro diretor da Unidade Orgânica, foi criada uma nova proposta que requer a sua decisão, por favor, dirija-se à plataforma de gestão de contratações para saber mais informações",
}

let mailOptionsCTC = {
    from: "estg@gmail.com",
    to: "2151571@my.ipleiria.pt",
    subject: "Nova Proposta na plataforma de contratações",
    text: "Caro membro do Conselho Tecnico-Científico, foi criada uma nova proposta que requer a sua decisão, por favor, dirija-se à plataforma de gestão de contratações para saber mais informações",
}
/*
transporter.sendMail(mailOptions, function (error) {
    if (error) {
        console.log(error);
    }
    else {
        console.log('Email enviado para o diretor da unidade organica!');
    }
});
*/
//function sendEmail(){

app.listen(8080, function () {
    console.log('Listening on port 8080')
})

io.on('connection', function (socket) {
    console.log("Client connected");

    socket.on('email-diretor', function (data) {
        console.log(data);
        transporter.sendMail(mailOptionsDiretorUO, function (error) {
            if (error) {
                console.log(error);
            }
            else {
                console.log('Email enviado para o diretor da unidade organica!');
            }
        });
    });

    socket.on('email-ctc', function (data) {
        console.log(data);
        transporter.sendMail(mailOptionsCTC, function (error) {
            if (error) {
                console.log(error);
            }
            else {
                console.log('Email enviado para o diretor da unidade organica!');
            }
        });
    });
});

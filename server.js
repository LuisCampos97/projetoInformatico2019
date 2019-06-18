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

let mailOptionsSecretariadoDirecao = {
    from: "estg@gmail.com",
    to: "2151571@my.ipleiria.pt",
    subject: "Nova Proposta na plataforma de contratações",
    text: "Caro membro do Secretariado da Direção, foi criada uma nova proposta que requer a sua decisão, por favor, dirija-se à plataforma de gestão de contratações para saber mais informações",
}

let mailOptionsRecursosHumanos = {
    from: "estg@gmail.com",
    to: "2151571@my.ipleiria.pt",
    subject: "Nova Proposta na plataforma de contratações",
    text: "Caro membro dos Recursos Humanos, foi criada uma nova proposta que requer a sua decisão, por favor, dirija-se à plataforma de gestão de contratações para saber mais informações",
}


app.listen(8080, function () {
    console.log('Listening on port 8080')
})

io.on('connection', function (socket) {
    console.log("Client connected");

    socket.on('email-diretor', function (data) {
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
        transporter.sendMail(mailOptionsCTC, function (error) {
            if (error) {
                console.log(error);
            }
            else {
                console.log('Email enviado para o Conselho Tecnico-Cientifico!');
            }
        });
    });

    socket.on('email-secretariado', function (data) {
        transporter.sendMail(mailOptionsSecretariadoDirecao, function (error) {
            if (error) {
                console.log(error);
            }
            else {
                console.log('Email enviado para o Secretariado da Direção!');
            }
        });
    });

    socket.on('email-docente', function (data) {
        let mailOptionsDocente = {
            from: "estg@gmail.com",
            to: data.email,
            subject: "Nova Proposta na plataforma de contratações",
            //text: "Caro docente a ESTG pretende contrata-lo!!",
            html: '<p>Caro '+ data.nome_completo +' a ESTG pretende contrata-lo!!</p><br><a href="http://projetoinformatico.project:8080/#/login"> Clique aqui para ser redirecionado para a pagina de login da aplicação </a>'
            //check nodemailer.markdown
        }
        transporter.sendMail(mailOptionsDocente, function (error) {
            if (error) {
                console.log(error);
            }
            else {
                console.log('Email enviado o docente a ser contratado!');
            }
        });
    });

    socket.on('email-recursos-humanos', function (data) {
        console.log(data);
        transporter.sendMail(mailOptionsRecursosHumanos, function (error) {
            if (error) {
                console.log(error);
            }
            else {
                console.log('Email enviado o membro dos Recursos Humanos!');
            }
        });
    });

});

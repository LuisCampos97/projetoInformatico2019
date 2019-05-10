require('dotenv').config();
var app = require('http').createServer();
var io = require('socket.io')(app);

const nodemailer = require('nodemailer');

let transporter = nodemailer.createTransport({
    service:'gmail',
    auth:{
        user: process.env.MAIL_USERNAME,
        pass: process.env.MAIL_PASSWORD,
    }
});
let mailOptions = {
    from:"proponenteESTG@gmail.com",
    to:"2151571@my.ipleiria.pt",
    subject:"Nova proposta na aplicação de gestão de contratações",
    text:"Tem uma nova proposta",
}
//function sendEmail(){

app.listen(8080, function(){
    console.log('Listening on port 3000')
})

    io.on('connection', function (socket) {
        console.log("Client connected");

        socket.on('email-diretor', function (data) {  
            console.log(data);
            transporter.sendMail(mailOptions, function(error){
                if(error){
                    console.log(error);
                }
                else{
                    console.log('Email enviado para o diretor da unidade organica!');
                }
            });
        });
      });
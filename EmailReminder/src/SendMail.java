/* 
Tutorials Point © Copyright 2018. All Rights Reserved.
Refer to https://www.tutorialspoint.com/javamail_api/javamail_api_gmail_smtp_server.htm
*/
import java.util.Properties;

import javax.mail.Message;
import javax.mail.MessagingException;
import javax.mail.PasswordAuthentication;
import javax.mail.Session;
import javax.mail.Transport;
import javax.mail.internet.InternetAddress;
import javax.mail.internet.MimeMessage;

public class SendMail {
   public static void send(String aimEmailAdr, String title, String msg) {
      // Recipient's email ID needs to be mentioned.
      String to = aimEmailAdr;//change accordingly

      // Sender's email ID needs to be mentioned
      String from = "ziqiproject@gmail.com";//change accordingly
      String groomerEmail = "ziqiproject@163.com";
      final String username = "ziqiproject@gmail.com";//change accordingly
      final String password = "ZIQI2018";//change accordingly

      // Assuming you are sending email through relay.jangosmtp.net
      String host = "smtp.gmail.com";

      Properties props = new Properties();
      props.put("mail.smtp.auth", "true");
      props.put("mail.smtp.starttls.enable", "true");
      props.put("mail.smtp.host", host);
      props.put("mail.smtp.port", "587");

      // Get the Session object.
      Session session = Session.getInstance(props,
      new javax.mail.Authenticator() {
         protected PasswordAuthentication getPasswordAuthentication() {
            return new PasswordAuthentication(username, password);
         }
      });

      try {
         // Create a default MimeMessage object.
         Message message = new MimeMessage(session);

         // Set From: header field of the header.
         message.setFrom(new InternetAddress(from));

         // Set To: header field of the header.
         message.setRecipients(Message.RecipientType.TO,
         InternetAddress.parse(to));
         
         message.setRecipients(Message.RecipientType.CC,
         InternetAddress.parse(groomerEmail));

         // Set Subject: header field
         message.setSubject(title);

         // Now set the actual message
         message.setText(msg);

         // Send message
         Transport.send(message);

         System.out.println("Sent message successfully....");

      } catch (MessagingException e) {
            throw new RuntimeException(e);
      }
   }
}
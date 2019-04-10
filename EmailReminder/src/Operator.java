import java.text.ParseException;
import java.util.ArrayList;

import javax.xml.transform.TransformerException;

public class Operator {

	public static void main(String[] args) throws ParseException, TransformerException {
		
		
		
		boolean term = true;
		
		while(term) {
			ArrayList<String> emailList = DomRead.checkAppointment();
			
			if(emailList.size() != 0) {
				for(String tempStr: emailList) {
					String[] userInfos = tempStr.split(",");
					String email = userInfos[0];
					String name = userInfos[1];
					String dogName = userInfos[2];
					String time = userInfos[3];
					String title = "Tom Grooming Notification: " + name;
					String msg = "Hi " + name + "\r\n" + "Appointment of grooming for your dog " + dogName + "is tomorrow " + time + "." + "\r\n" 
									+ "Kind Regards,\r\n" + "Tom Pet Grooming";
					System.out.println("--------------------------------------------------------------------------------");
					System.out.println("Email to " + name + "with Email " + email);
					System.out.println("Email Title: " + title);
					System.out.println("Email Content: " + msg);
					System.out.println("--------------------------------------------------------------------------------");
					
					
					SendMail.send(email, title, msg);
					 try{
						 Thread.currentThread().sleep(15000);
					 }catch(InterruptedException ie){
						 ie.printStackTrace();
					 }
					 
				}
			}			
			 try{
				 Thread.currentThread().sleep(30000);
			 }catch(InterruptedException ie){
				 ie.printStackTrace();
			 }
			
		}
	}

}

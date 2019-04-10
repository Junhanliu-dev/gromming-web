
import java.io.File;
import java.io.IOException;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.parsers.ParserConfigurationException;
import javax.xml.transform.Transformer;
import javax.xml.transform.TransformerException;
import javax.xml.transform.TransformerFactory;
import javax.xml.transform.dom.DOMSource;
import javax.xml.transform.stream.StreamResult;

import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;
import org.w3c.dom.Text;
import org.xml.sax.SAXException;

public class DomRead {

    public static ArrayList<String> checkAppointment() throws ParseException, TransformerException {

        DocumentBuilderFactory dbf = DocumentBuilderFactory.newInstance();
        
        ArrayList<String> emailList = new ArrayList<String>();
        
        try {

            DocumentBuilder db = dbf.newDocumentBuilder();

            Document document = db.parse("test.xml");

            NodeList Accounts = document.getElementsByTagName("Account");

            for (int i = 0; i < Accounts.getLength(); i++) {

                Element Account = (Element) Accounts.item(i);
                

                NodeList Appoinments = Account.getElementsByTagName("Appointment");

                for (int k = 0; k < Appoinments.getLength(); k++) {

                    	Element Appointment = (Element) Appoinments.item(k);
                    	
                    	String ApponDate = Appointment.getElementsByTagName("Date").item(0).getFirstChild().getNodeValue();
                    	String ApponTime = Appointment.getElementsByTagName("Time").item(0).getFirstChild().getNodeValue();
                    	String ApponCancel = Appointment.getElementsByTagName("Cancel").item(0).getFirstChild().getNodeValue();
                    	String AccountName = Account.getElementsByTagName("Name").item(0).getFirstChild().getNodeValue();
                    	String AccountEmail = Account.getElementsByTagName("Email").item(0).getFirstChild().getNodeValue();
                    	String AccountDogName = Account.getElementsByTagName("DogName").item(0).getFirstChild().getNodeValue();
                    	Element EleApponSent = (Element) Appointment.getElementsByTagName("SentEmail").item(0);
                    	String ApponSent = EleApponSent.getFirstChild().getNodeValue();
                    	String ApponDT = "2018-5-"+ ApponDate + " " + ApponTime + ":00";
                    	Date Now = new Date();
                    	SimpleDateFormat sdf=new SimpleDateFormat("yyyy-MM-dd hh:mm:ss");  
                    	String dateNowStr = sdf.format(Now);    
                    	
                    	if(compare(ApponDT, dateNowStr) && ApponCancel.equals("NO") && ApponSent.equals("NO")) {
                    		String userEmailInfo = AccountEmail + "," + AccountName + "," + AccountDogName + "," + ApponTime;
                    		emailList.add(userEmailInfo);
                    		EleApponSent.setTextContent("YES");
                    	}
                }      
            }
            
            TransformerFactory tf=TransformerFactory.newInstance();

            Transformer ts=tf.newTransformer();

            ts.transform(new DOMSource(document), new StreamResult(new File("test.xml")));
        } catch (ParserConfigurationException e) {
            e.printStackTrace();
        } catch (SAXException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }
		return emailList;
    }
    
    private static boolean compare(String apponTime,String nowTime) throws ParseException  
    {  

        SimpleDateFormat sdf=new SimpleDateFormat("yyyy-MM-dd hh:mm:ss");  

        Date apt = sdf.parse(apponTime);  
        Date now =sdf.parse(nowTime);  

        long  between = apt.getTime() - now.getTime();
        if(between < (24* 3600000)){
            return true;
        }
        return false;

    }
    
    

}
// Includes for work with the server web panel
#include <Bridge.h>
#include <YunServer.h>
#include <YunClient.h>
#include <FileIO.h>

// Includes for work with temperature sensors
#include <OneWire.h>
#include <DallasTemperature.h>

// Setup a oneWire instance to communicate with any OneWire devices (at digital pin 8)
OneWire oneWire(8);

// Pass our oneWire reference to Dallas Temperature.
DallasTemperature sensors(&oneWire);

// Here you must to put your sensors addresses
DeviceAddress Probe01 = { 0x28, 0xF8, 0x9D, 0x22, 0x05, 0x00, 0x00, 0xD4 }; 
DeviceAddress Probe02 = { 0x28, 0x4C, 0xA8, 0x22, 0x05, 0x00, 0x00, 0x59 };
DeviceAddress Probe03 = { 0x28, 0x65, 0xB3, 0x22, 0x05, 0x00, 0x00, 0x75 };

// The server instance 
YunServer server; 
YunClient client;

// Counter loops and current loop number are variables used for controlling phases and alarm. 
unsigned int loop_counter, loop_number;

 
void setup() {
  
  loop_counter = 5;
  loop_number = 0;
  
  pinMode(13, INPUT);  //phase 3
  pinMode(12, INPUT);  //phase 2
  pinMode(11, INPUT);  //phase 1
  pinMode(10, INPUT);  //alarm
  
  /* Reference values 
     
     Phases:
             LOW=Phase disconnected,  HIGH=Phase connected  
     Alarm:
             LOW=OK,  HIGH=Alarm warning 
  */
  
  Bridge.begin();
 
  FileSystem.begin();

  server.listenOnLocalhost();
  server.begin();

  // Initialize the Temperature measurement library
  sensors.begin();
  
  // Set the resolution to 10 bit (Can be 9 to 12 bits .. lower is faster)
  sensors.setResolution(Probe01, 10);
  sensors.setResolution(Probe02, 10);
  sensors.setResolution(Probe03, 10);
}
 
void loop() {
  
  sensors.requestTemperatures();  
  
  client = server.accept(); 
 
  if (client) {
    
    File statesensor_file = FileSystem.open("/mnt/sda1/webexample/sensors_states.config");
    File limittemp_file = FileSystem.open("/mnt/sda1/webexample/limitTemp.config");

    /* These files just stores one char value: 1 or 0
       variable for reading enabled (1) o disabled (0) value */
    char c1 = NULL ; char c2 = NULL; char c3 = NULL;
    if (statesensor_file){
         statesensor_file.seek(3);  //move read pointer to read 0/1 value
         c1 = statesensor_file.read();  
         statesensor_file.seek(8);
         c2 = statesensor_file.read();
         statesensor_file.seek(13);
         c3 = statesensor_file.read();
    }
    statesensor_file.close();
    delay(250);
    
    // Get the limit temperature value. I'l use the same file variable declared above
    char limit_temp[5];
    float max_value;
    int i=0;
    if (limittemp_file){
          while(limit_temp[i-1] != EOF){
            limit_temp[i]=limittemp_file.read();
            i++;
          }
          max_value=atoi(limit_temp);
    }
    limittemp_file.close();
    delay(250); 
    
    // Do the following tasks every 5 polled loops
    // Asking about phases and alarm states
    if(fmod(loop_counter,5)==0){

      // Passing digital values of the phases and the alarm to the web server. 
      // It will be executed by "readPhasesAndAlarm" javascript function.
      String sendData = "<script> readPhasesAndAlarm(";
      
      sendData += String(digitalRead(10));  
      delay(250);
      sendData += "," + String(digitalRead(11));  
      delay(250);
      sendData += "," + String(digitalRead(12)); 
      delay(250);
      sendData += "," + String(digitalRead(13));  
      delay(250); 
      sendData += "); </script>";

      client.print(sendData);
      delay(500);
      
    }
        
    String command = client.readString();
    command.trim();

    if (command == "temperature") {
      
      client.print("<p style='margin-left:220px'><strong> Current temperature at sensor 1: </strong></p>");
      printHtmlHeaderTemp(c1,1);      
      client.print("</br>");
      client.print("<p style='margin-left:220px'><strong> Current temperature at sensor 2: </strong></p>");
      printHtmlHeaderTemp(c2,2);      
      client.print("</br>");
      client.print("<p style='margin-left:220px'><strong> Current temperature at sensor 3: </strong></p>");
      printHtmlHeaderTemp(c3,3);      
      
      /* 
        Querying the temperature values of sensor to avoid device damages
      
        If case: if at least one sensor is enabled and its temperature reached the maximum value
        Loopcounter: this variable controls the execution of this block, it only can be executed after 25 pulled loops to avoid a performance drop of Yun Server.       
      */
      
      if ((((c1 == '1') && (printTemperature(Probe01) > max_value)) || 
          ((c2 == '1') && (printTemperature(Probe02) > max_value)) ||
           ((c3 == '1') && (printTemperature(Probe03) > max_value))) && (loop_counter > (loop_number+25)))
        { 
        
           Process p2;
        
           // This process also call the shutdown cluster from the python script
           p2.begin("/mnt/sda1/webexample/sendLogTempByMail.py");

           if (c1 == '1')
               p2.addParameter(String(printTemperature(Probe01),2)+" °C");
           else p2.addParameter("DISABLED");        

           if (c2 == '1')        
               p2.addParameter(String(printTemperature(Probe02),2)+" °C");
           else p2.addParameter("DISABLED");

           if (c3 == '1')        
               p2.addParameter(String(printTemperature(Probe03),2)+" °C");
           else p2.addParameter("DISABLED");
        
           p2.runAsynchronously();
        
           // Give some time to do the task       
           delay(10000);
        
           loop_number = loop_counter;
        }  
    }
   
    client.stop();
  }
  
  loop_counter++;  
  delay(1000);
}

/*-----( Declare User-written Functions )-----*/
float printTemperature(DeviceAddress deviceAddress)
{
   if (sensors.getTempC(deviceAddress) == -127.00) 
     return -127;
   else
     return sensors.getTempC(deviceAddress);  
}// End printTemperature

void printHtmlHeaderTemp (char c, unsigned sensorNum){
        
  if (c == '0')  
    client.print("<p style='color:#FF0000; margin-left:220px'><em> DISABLED </em></p>");    
      
  else if (c == '1')
  {     
    client.print("<p style='color:#FF0000; margin-left:220px'>");
    if (sensorNum == 1)
      client.print(printTemperature(Probe01));
    else if (sensorNum == 2)
          client.print(printTemperature(Probe02));
    else
          client.print(printTemperature(Probe03));

    client.print(" °C");
    client.print("</p>");
  }
} 

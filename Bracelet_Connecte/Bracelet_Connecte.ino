#include "Akeru.h"
#include <SoftwareSerial.h>
#include <Wire.h>

void setup() {
  Serial.begin(9600);
  delay(1);
  Wire.begin();
  delay(1);
  Serial.println("Starting...");
  delay(1000);
  Akeru.begin();
  delay(1000);
}

typedef struct {
  double lat;
  double lon;
} GPS;

void loop() {
    GPS p;
  int i= 0;
  double flat, flon = 0;
   read_data(&flat, &flon);
   p.lat = conv_coords(flat);
   p.lon = conv_coords(flon);  
   if(p.lat == 0|| p.lon == 0){
    Serial.println("GPS no datas");
    for(i=0;i<5;i++){
     delay(1000);
    }
   } else {
    Serial.println("GPS datas sent");
    Akeru.send(&p,sizeof(p));
    //Wait 2min30s
    for(i=0;i<150;i++){
     delay(1000);
    }
  }
}

void read_data(double* flat, double* flon){               // Reading data response from serial xbee
  uint8_t x;
  char gpsdata[100];
  while(Serial.available()==0){}
  if(Serial.available()>0){
    char c = Serial.read(); Serial.print(c);
    if(c == '$')
      {char c1 = Serial.read(); Serial.print(c1);
       if(c1 == 'G')
         {char c2 = Serial.read(); Serial.print(c2);
          if(c2 == 'P')
            {char c3 = Serial.read(); Serial.print(c3);
             if(c3 == 'G')
               {char c4 = Serial.read(); Serial.print(c4);
                if(c4 == 'G')
                   {char c5 = Serial.read(); Serial.print(c5);
                    if(c5 == 'A')
                       {
                         for(x=0;x<65;x++)
                         { 
                           gpsdata[x]= Serial.read();
                           while (gpsdata[x] == '\r' || gpsdata[x] == '\n' || gpsdata[x] == '\0')
                           {
                             gpsdata[x+1] = '\0';
                             Serial.print(gpsdata[x]);
                             break;
                           }
                        }
                      }
                      else{
                        Serial.println("Not a GPGGA string");
                      }
                   }
               }
            }     
         }
      }
      Serial.println(gpsdata);
      *flat = atof((const char *)getValue(gpsdata, ',', 2).c_str());
      *flon = atof((const char *)getValue(gpsdata, ',', 4).c_str());
  }
  Serial.flush();             // Clear serial buffer
}

//Split array with characters ','
String getValue(String data, char separator, int index)
{
   int found = 0;
    int strIndex[] = {0, -1  };
    int maxIndex = data.length()-1;
    for(int i=0; i<=maxIndex && found<=index; i++){
      if(data.charAt(i)==separator || i==maxIndex){
        found++;
        strIndex[0] = strIndex[1]+1;
        strIndex[1] = (i == maxIndex) ? i+1 : i;
      }
   }
    return found>index ? data.substring(strIndex[0], strIndex[1]) : "";
}

//Converting Coordinates from GPS-style (ddmm.ssss) to Decimal Style (dd.mmssss) 
double conv_coords(double in_coords)
{
  //Initialize the location.
  double f = in_coords;
  // Get the first two digits by turning f into an integer, then doing an integer divide by 100;
  // firsttowdigits should be 77 at this point.
  int firsttwodigits = ((int)f)/100; //This assumes that f < 10000.
  double nexttwodigits = (double)(firsttwodigits*100);
  double nexttwodigits2 = f - nexttwodigits;
  double theFinalAnswer = (double)(firsttwodigits + nexttwodigits2/60.0);
  return theFinalAnswer;
}

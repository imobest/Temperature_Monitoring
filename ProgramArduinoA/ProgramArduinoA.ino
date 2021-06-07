#include <SPI.h>
#include <Ethernet.h>
#include <OneWire.h>
#include <DS18B20.h>

byte mac[] = {  0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
const byte ONEWIRE_PIN = 2;

IPAddress ip(192, 168, 43, 35);


IPAddress myDns(8, 8, 8, 8);

OneWire onewire(ONEWIRE_PIN);
DS18B20 ds(2);
EthernetClient client;

char server[] = "www.jakublenz.pl";

unsigned long lastConnectionTime = 0; // last time you connected to the server, in milliseconds
const unsigned long postingInterval = 10 * 1000; // delay between updates, in milliseconds
byte licz;

//#######
float tempArr[5] = {0, 0, 0, 0, 0};
int sensorID = 1;

void setup() {
  Serial.begin(9600);
  while (!Serial) {
    ;
  }
  setUpEthernetShield(); // initialize ES

  pinMode(4, OUTPUT); //ustawnienie pinu

  // give the Ethernet shield a second to initialize:
  delay(1000);
}



void loop() {
          Ethernet.begin(mac, ip, myDns);
  if (client.available()) {
    char c = client.read();
    Serial.write(c);
  }

  if (millis() - lastConnectionTime > postingInterval) {
    if (licz == 6) {
      Serial.println("sending");
      httpRequest();
      licz = 0;
    }
    Serial.print(licz);
    licz++;
    lastConnectionTime = millis();
  }
}


void httpRequest() {
  Serial.print("Devices: ");
  Serial.println(ds.getNumberOfDevices());
  Serial.println();
  client.stop();

  sensorID = 1; //ustawienie pierwszego sensora

  while (ds.selectNext()) {
    String URL = "/projekt/php/add.php?";
    byte address[8];
    ds.getAddress(address);
    char adres[32];
    //    sprintf(adres, "%x", address);
    array_to_string(address, 4, adres);
    URL.concat("&adres=");
    URL.concat(adres);
    URL.concat("&temp="); URL.concat( ds.getTempC() );

    tempArr[ sensorID - 1 ] = ds.getTempC(); //przypisanie do tablicy temperatur

    if (client.connect(server, 80)) {
      Serial.println("connecting...");
      Serial.println(URL);
      // send the HTTP GET request:
      client.println(String("GET ") + URL + " HTTP/1.1");
      Serial.println(String("GET ") + URL + " HTTP/1.1");
      client.println("Host: jakublenz.pl");
      Serial.println("Host: jakublenz.pl");
      client.println("User-Agent: arduino-ethernet");
      Serial.println("User-Agent: arduino-ethernet");
      client.println("Connection: close");
      Serial.println("Connection: close");
      client.println();
      Serial.println();
      // note the time that the connection was made:
      //      lastConnectionTime = millis();
    } else {
//      // if you couldn't make a connection:
//      Serial.println("connection failed");
        Ethernet.begin(mac, ip, myDns);
//      httpRequest();///// to zmienione
//      Serial.print("Setting static IP address: ");
//      Serial.println(Ethernet.localIP());
    }
    sensorID++; //kolejny sensor
  }

  if (tempArr[0] > 26.0 || tempArr[1] > 26.0 || tempArr[2] > 26.0 || tempArr[3] > 26.0 || tempArr[4] > 26.0){
    digitalWrite(4, HIGH);
  } else {
    digitalWrite(4, LOW);
  }

}

void setUpEthernetShield() {
  Serial.println("Initialize Ethernet with DHCP:");
  if (Ethernet.begin(mac) == 0) {
    Serial.println("Failed to configure Ethernet using DHCP");
    // Check for Ethernet hardware present
    if (Ethernet.hardwareStatus() == EthernetNoHardware) {
      Serial.println("Ethernet shield was not found.  Sorry, can't run without hardware. 😞");
      while (true) {
        delay(1); // do nothing, no point running without Ethernet hardware
      }
    }
    if (Ethernet.linkStatus() == LinkOFF) {
      Serial.println("Ethernet cable is not connected.");
    }
    // try to congifure using IP address instead of DHCP:
    Ethernet.begin(mac, ip, myDns);
    Serial.print("My IP address: ");
    Serial.println(Ethernet.localIP());
  } else {
    Serial.print("  DHCP assigned IP ");
    Serial.println(Ethernet.localIP());
  }
}

void array_to_string(byte array[], unsigned int len, char buffer[])
{
  for (unsigned int i = 0; i < len; i++)
  {
    byte nib1 = (array[i] >> 4) & 0x0F;
    byte nib2 = (array[i] >> 0) & 0x0F;
    buffer[i * 2 + 0] = nib1  < 0xA ? '0' + nib1  : 'A' + nib1  - 0xA;
    buffer[i * 2 + 1] = nib2  < 0xA ? '0' + nib2  : 'A' + nib2  - 0xA;
  }
  buffer[len * 2] = '\0';
}

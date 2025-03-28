
#include <ESP8266WiFi.h>

const int trigPin = 9;    // Trigger pin
const int echoPin = 10;   // Echo pin
const int buzzerPin = 11; // Buzzer pin
const int maxDistance = 200; // 200 cm = 2 meters

void setup() {
  pinMode(trigPin, OUTPUT);
  pinMode(echoPin, INPUT);
  pinMode(buzzerPin, OUTPUT);
  Serial.begin(9600); // Optional: For debugging
}

void loop() {
  // Clear trigger pin
  digitalWrite(trigPin, LOW);
  delayMicroseconds(2);
  
  // Send 10μs pulse to trigger
  digitalWrite(trigPin, HIGH);
  delayMicroseconds(10);
  digitalWrite(trigPin, LOW);
  
  // Measure echo pulse duration (μs)
  long duration = pulseIn(echoPin, HIGH, 25000); // Timeout for ~4m max range
  
  // Calculate distance in centimeters
  int distance = duration * 0.0343 / 2; // Speed of sound = 0.0343 cm/μs

  // Activate buzzer if obstacle ≤ 2 meters
  if (distance <= maxDistance && distance > 0) {
    tone(buzzerPin, 1000); // 1kHz tone
    Serial.print("Obstacle detected at: ");
    Serial.print(distance);
    Serial.println(" cm");
  } else {
    noTone(buzzerPin); // Turn off buzzer
  }
  
  delay(100); // Short delay between readings
}

# Punctuality Pal

This is my final project for my IoT course.

It consists of an app for the [Bangle.js](https://banglejs.com/) (v1) smartwatch that allows you to track the timetables of the ferry I need to take to the school.

There is also an android app which is used to send your GPS location to the server and update estimated arrival time.

Also included is the server code which is used to store the timetable and the GPS location.



## Problem

On my route to school, I need to take the ferry. Which has a very strict timetable. And with irregular hours for classes, I need to know when to depart so I can still catch the ferry and be on time. 

![](/rsc/problem.png) ![]() ![](/rsc/timetable.png)

The timetables for the ferry are only avaible as a pdf and not accessible via e.g. Google Maps. And because I go by bike I wanted a hands-free solution.

So my project idea was a hands-free routeplanner / tracker


## Solution

My initial concept was quite simple. Use a smartwatch connected to a server to track :
- Current Time
- Current Location
- Current Speed


Which could then be used to calculate and forward the following :

- Next Ferry Departure
- Estimated Arrival Time to Ferry


## Smartwatch

![](/rsc/bangle_2.png)

For the choice of smartwatch the most important points where :
- The watch needs to be able to communicate to a server
- The watch needs to be able to track your location

In this case I used the [Bangle.js](https://banglejs.com/) (v1) smartwatch. Because of the built in GPS & BLE functionality. The bangle does not have network connectivity. So I needed a way to communicate with the server. For this I chose to use an android app.




## Android App

### PP-Bridge

[APK](/pp-bridge/app-debug.apk)

BLE connectivity 

app 

repo

picture




### Server

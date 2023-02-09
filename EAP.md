# EAP: Architecture Specification and Prototype

Helluva is a web platform for events management.

## A7: Web Resources Specification

In this artefact the resources to be used in the Helluva web application are defined and described, listing their properties using OpenAPI (YAML). 

### 1. Overview

In this section, an overview of the web application is presented using modules to separate resources.

| Module | Description |
| ------- | ------------------------ |
| **M01: Authentication and Individual Profile** | Web resources associated with user authentication and individual profile management. Includes the following system features: login/logout, registration and view personal profile information. |
| **M02: View Content** | Web resources associated with events. Includes the following system features: view event participants, event page and home page. |
| **M03: Search** | Web resources associated with searching events. Includes the following system features: search for events. |
| **M04: Manage Content** | Web resources associated with event management. Includes the following system features: create/edit/delete new event and invite users to an event. |
| **M05: User Administration and Static pages** | Web resources associated with user management, specifically: view reported users/events/comments. Web resources with static content are associated with this module: about, FAQ and contacts. |

### 2. Permissions

In this section, the permissions associated with web resources are presented.

| Identifier | Name | Description |
| ------- | ------ | ------------------------ |
| **PUB** | Public | Users without privileges |
| **USR** | User | Authenticated users |
| **ATT** | Attendee | Autenticated user participating in the event |
| **OWN** | Owner | Authenticated users with editing privileges over their events |
| **ADM** | Administrator | System administrators |

### 3. OpenAPI Specification

OpenAPI specification in YAML format to describe the web application's web resources.

[a7 openapi.yaml](a7 openapi.yaml)

```yaml
openapi: 3.0.0
info:
  title: Event manager Web API
  version: '1.0'
  description: Web Resources Specification (A7) for Helluva
  x-logo:
    url: ''
servers:
  - url: http://lbaw2235.fe.up.pt/
    description: Production server
paths:
  /login/:
    get:
      tags:
        - 'M01: Authentication and Individual Profile'
      responses:
        '200':
          description: Ok. Show Log-in UI
      operationId: R101
      summary: 'R101: login to user'
      description: 'Provide login form. Access: USR'
    post:
      requestBody:
        content:
          application/x-www-form-urlencoded:
            schema:
              required:
                - email
                - password
              type: object
              properties:
                email:
                  type: string
                password:
                  type: string
        required: true
      tags:
        - 'M01: Authentication and Individual Profile'
      responses:
        '302':
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: Successful authentication. Redirect to user profile.
                  value: /users/{id}
                302Error:
                  description: Failed authentication. Redirect to login form.
                  value: /login
          description: Redirect after processing the login credentials.
      operationId: R102
      summary: 'R102: Login Action'
      description: 'Processes the login form submission. Access: PUB'
  /logout:
    post:
      tags:
        - 'M01: Authentication and Individual Profile'
      responses:
        '302':
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: Successful logout. Redirect to login form.
                  value: /login
          description: Redirect after processing logout.
      operationId: R103
      summary: 'R103: Logout Action'
      description: 'Logout the current authenticated user. Access: USR, ADM'
  /register:
    get:
      tags:
        - 'M01: Authentication and Individual Profile'
      responses:
        '200':
          description: Ok. Show Sign-Up UI
      operationId: R104
      summary: 'R104: Register Form'
      description: 'Provide new user registration form. Access: PUB'
    post:
      requestBody:
        content:
          application/x-www-form-urlencoded:
            schema:
              required:
                - email
                - password
              type: object
              properties:
                name:
                  type: string
                email:
                  type: string
                username:
                  type: string
                picture:
                  format: binary
                  type: string
        required: true
      tags:
        - 'M01: Authentication and Individual Profile'
      responses:
        '302':
          headers:
            Location:
              required: false
              deprecated: false
              schema:
                type: string
              examples:
                302Success:
                  description: account registered
                302Error:
                  description: username already taken
              description: ''
          description: Redirect after processing info
      operationId: R105
      summary: 'R105: Register Action'
      description: 'Processes the new user registration form submission. Access: PUB'
  /users/{id}:
    get:
      tags:
        - 'M01: Authentication and Individual Profile'
      parameters:
        - name: id
          schema:
            type: integer
          in: path
          required: true
      responses:
        '200':
          description: Ok. Show view profile UI
      operationId: R106
      summary: 'R106: View user profile'
      description: 'Show the individual user profile. Access: USR'
  /about_us:
    summary: ''
    description: ''
    get:
      tags:
        - 'M05: User Administration and Static pages'
      responses:
        '200':
          description: Ok. Show 'About Us' page.
          x-last-modified: 1668423515335
      operationId: R501
      summary: 'R501: Show ''About Us'' page'
      description: 'Direct to ''About Us'' page. Access: PUB'
    x-last-modified: 1668423849530
  /contact_us:
    summary: ''
    description: ''
    get:
      tags:
        - 'M05: User Administration and Static pages'
      responses:
        '200':
          description: Ok. Show 'Contact Us' page.
          x-last-modified: 1668424486577
      operationId: R502
      summary: 'R502: Show ''Contact Us'' page'
      description: 'Direct to ''Contact Us'' page. Access: PUB'
    x-last-modified: 1668423951220
  /faq:
    get:
      tags:
        - 'M05: User Administration and Static pages'
      responses:
        '200':
          description: Ok. Show 'FAQ' page.
          x-last-modified: 1668424513004
      operationId: R503
      summary: 'R503: Show ''FAQ'' page'
      description: 'Direct to ''FAQ'' page. Access: PUB'
    x-last-modified: 1668424175533
  /reported_users:
    get:
      tags:
        - 'M05: User Administration and Static pages'
      responses:
        '200':
          description: Ok. Display reported users.
          x-last-modified: 1668426246558
      operationId: R504
      summary: 'R504: View reported users'
      description: 'Display the list of reported users. Access: ADM'
    x-last-modified: 1668426189615
  /reported_events:
    get:
      tags:
        - 'M05: User Administration and Static pages'
      responses:
        '200':
          description: Ok. Display reported events.
          x-last-modified: 1668426354531
      operationId: R505
      summary: 'R505: View reported events'
      description: 'Display all the reported events. Access: ADM'
    x-last-modified: 1668426301253
  /reported_comments:
    summary: ''
    get:
      tags:
        - 'M05: User Administration and Static pages'
      responses:
        '200':
          description: Ok. Show reported comments.
          x-last-modified: 1668426440595
      operationId: R506
      summary: 'R506: View reported comments'
      description: 'Display all reported comments. Access: ADM'
    x-last-modified: 1668426384694
  /create_event:
    get:
      tags:
        - 'M04: Manage Content'
      responses:
        '200':
          description: Ok. Show create event UI.
          x-last-modified: 1668427968652
      operationId: R401
      summary: 'R401: Create new event form'
      description: 'Provide new event form. Access: USR'
    post:
      requestBody:
        content:
          application/x-www-form-urlencoded:
            schema:
              required:
                - date
                - type
              type: object
              properties:
                name:
                  type: string
                category:
                  type: string
                date:
                  type: date
                picture:
                  format: binary
                  type: string
                type:
                  type: boolean
        required: false
      tags:
        - 'M04: Manage Content'
      responses:
        '302':
          description: Redirect after processing info.
          x-last-modified: 1668427627584
      operationId: R402
      summary: 'R402: Create new event action'
      description: 'Processes the new event registration form submission. Access: USR'
    x-last-modified: 1668428087844
  /search:
    get:
      operationId: R301
      summary: 'R301: Search'
      description: 'Search for events using text. Access: USR'
      tags:
       - 'M03: Search'

      parameters:
       - in: query
         name: string
         description: String to use for search
         schema:
            type: string
         required: true

      responses:
       '200':
         description: 'Ok. Show search UI'
         content:
            application/json:
                schema:
                    type: array
                    items:
                        type: object
                        properties:
                           content:
                             type: string
       '400':
         description: Bad Request
    x-last-modified: 1668532586959
  /api/invite:
    post:
      tags:
        - 'M04: Manage Content'
      responses:
        '200':
          description: Ok. Invite
      operationId: R403
    x-last-modified: 1668532869526
  /user/attend:
    get:
      tags:
        - 'M02: View Content'
      responses:
        '200':
          description: Ok. Show 'Attend' page.
      operationId: R201
    x-last-modified: 1668533586316
  /user/manage:
    get:
      tags:
        - 'M02: View Content'
      responses:
        '200':
          description: Ok. Show 'Manage' page.
      operationId: R202
    x-last-modified: 1668533586316
  /event/edit/{event_id}:
    get:
      operationId: R404
      summary: 'R404: Edit Event Form'
      description: 'Provide the event form to an user for edition. Access: OWN, ADM'
      tags:
        - 'M04: Manage Content'
        
      parameters:
        - in: path
          name: event_id
          schema:
            type: integer
          required: true
          
      responses:
        '200':
          description: 'Show form to edit an event.'
          
    post:
      operationId: R405
      summary: 'R405: Edit Event Action'
      description: 'Processes the event form edition submission. Access: OWN, ADM'
      tags:
        - 'M04: Manage Content'
        
      parameters:
        - in: path
          name: event_id
          schema:
            type: integer
          required: true
          
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                title:
                  type: string
                content:
                  type: string
                image:
                  type: string
                  format: binary
            required:
                - title
                - content
      responses:
       '302':
         description: 'Redirect after processing the event form edition.'
         headers:
           Location:
             schema:
               type: string
             examples:
               302Success:
                 description: 'The event edition was successful. Redirect to initial page.'
                 value: '/event/edit'
               302Error:
                 description: 'Failed to edit the event. Redirect to event form edition.'
                 value: '/event/edit/{event_id}'

    delete:
      operationId: R406
      summary: 'R406: Delete event'
      description: 'Delete an event. Access: OWN, ADM'
      tags:
        - 'M04: Manage Content'
        
      parameters:
        - in: path
          name: event_id
          schema:
            type: integer
          required: true
          
      responses:
        '302':
         description: 'Redirect after processing the event form.'
         headers:
           Location:
             schema:
               type: string
             examples:
               302Success:
                 description: 'The event was successfully deleted. Redirect to homepage.'
                 value: '/event/edit/'
               302Error:
                 description: 'Failed to delete the event. Redirect to the event page.'
                 value: '/event/edit/{event_id}'
    x-last-modified: 1668533755009
  /event/participants/{event_id}:
    get:
      requestBody:
        content:
          multipart/form-data:
            schema:
              required:
                - type
                - text
              type: object
        required: false
      tags:
        - 'M02: View Content'
      responses:
        '200':
          description: Ok. Show UI
      operationId: R203
      summary: 'R203: View participants event page'
      description: View participants event page
    x-last-modified: 1668534092987
    post:
      tags:
        - 'M02: View Content'
      responses:
        '200':
          description: Ok. Show UI
      operationId: R204
      summary: 'R204: View participants event page'
      description: View participants event page
  /event/{event_id}:
    get:
      requestBody:
        content:
          multipart/form-data:
            schema:
              required:
                - type
                - text
              type: object
        required: false
      tags:
        - 'M02: View Content'
      responses:
        '200':
          description: Ok. Show event page
      operationId: R205
      summary: 'R205: View event page'
      description: View the Event page and posts
    x-last-modified: 1668534107173
  /home:
    get:
      tags:
        - 'M02: View Content'
      responses:
        '200':
          description: Ok. Show home page
      operationId: R206
      summary: 'R206: View home page'
      description: View home page
    x-last-modified: 1668534206790
components:
  securitySchemes: {}
  schemas: {}
  headers: {}
  responses: {}
  parameters: {}
tags:
  - name: 'M01: Authentication and Individual Profile'
  - name: 'M02: View Content'
  - name: 'M03: Search'
    x-last-modified: 1668532422554
  - name: 'M04: Manage Content'
    x-last-modified: 1668533419645
  - name: 'M05: User Administration and Static pages'
security: []


```

---


## A8: Vertical prototype

In this artefact we include the implementation of the features that were considered necessary.

### 1. Implemented Features

#### 1.1. Implemented User Stories
  
The user stories implemented in the prototype are identified in this section.

| User Story reference | Name                   | Priority                   | Description                   |
| -------------------- | ---------------------- | -------------------------- | ----------------------------- |
| US01 | Sign-in | High | As a *Visitor*, I want to authenticate into the system, so that I can access priviliged information. |
| US02 | Sign-up | High | As a *Visitor*, I want to register an account, so that I can authenticate myself into the system. |
| US05 | Browse Public Events | High | As a *User*, I want to browse through public events, so that I can see the current available public events on the website. |
| US06 | View Public Event | High | As a *User*, I want to view a public event, so that I can see more detailed information about it. |
| US07 | Search Events | High | As a *User*, I want to search for events, so that I can more easily find events I'm interested in. |
| US11 | Manage Own Events | High | As a *Member*, I want to manage my own events, so that I can keep track and update them. |
| US12 | Manage Events Attended / to Attend | High | As a *Member*, I want to manage events I've attended or want to attend, so that I can track and keep a history of them. |
| US18 | Edit Event Details | High | As an *Event Organizer*, I want to edit event details, so that I keep everything updated. |
| US28 | View Event Messages | Medium | As an *Attendee*, I want to view event messages, so that I am aware of any updates on the event. |
| US33 | View Attendees List | Medium | As an *Attendee*, I want to view attendees list, so that I know who will participate in the event. |


#### 1.2. Implemented Web Resources

The web resources implemented in the prototype are identified in this section. 

**Module M01: Authentication and Individual Profile**

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R101: Login Form | GET [/login](http://lbaw2235.fe.up.pt/login) |
| R102: Login Action | POST /login |
| R103: Logout Action | POST /logout |
| R104: Register Form | GET [/register](http://lbaw2235.fe.up.pt/register) |
| R105: Register Action | POST /register |

**Module M02: View Content**

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R205: View Event Page  | GET [/event/{event_id}](http://lbaw2235.fe.up.pt/event/1) |
| R206: View Home Page | GET [/home](http://lbaw2235.fe.up.pt/home) |


**Module M03: Search**

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R301: Search | GET [/event/search](http://lbaw2235.fe.up.pt/event/search) |

**Module M04: Manage Content**
  
| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R404: Edit Event Form     | GET [/event/edit/{event_id}](http://lbaw2235.fe.up.pt/event/edit/1) |
| R405: Edit Event Action   | POST /event/edit/{event_id} |
| R406: Delete Event        | DELETE /event/edit/{event_id} |

**Module M05: User Administration and Static pages**

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
|  |  |
|  |  |
|  |  |

### 2. Prototype

The prototype is available at http://lbaw2235.fe.up.pt/

Credentials:

* admin user: admin@example.com / 123456
* regular user: 

The code is available at https://git.fe.up.pt/lbaw/lbaw2223/lbaw2235/

---


## Revision history

Changes made to the first submission:

1. No changes were made yet
2. 05/12/2022 - Added new permission role: ATT
***
GROUP2235, 19/11/2022

* Diogo Pinto, up201906067@up.pt
* Eduardo Duarte, up202004999@up.pt
* Marcelo Apolinário, up201603903@up.pt
* Ricardo Cruz, up202008789@up.pt

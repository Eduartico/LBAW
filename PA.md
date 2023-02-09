# PA: Product and Presentation

Helluva is an information system with a web interface to collaboratively manage events.

## A9: Product

Helluva focuses on gathering and managing events, with the develop of a website designed for FEUP students. Users can create their own events or see which events are active, and join them if intended. This is the perfect platform for interaction between users as well, as they can write and view posts and comments, regarding each specific event.


### 1. Installation

The final version of the source code is available [here](https://git.fe.up.pt/lbaw/lbaw2223/lbaw2235/-/tree/main/webapp). 

Docker commands to start the image:

```
docker run -it -p 8000:80 -e DB_SCHEMA="lbaw2235" -e DB_DATABASE="lbaw2235" -e DB_USERNAME="lbaw2235" -e DB_PASSWORD="yavmJBXK" git.fe.up.pt:5050/lbaw/lbaw2223/lbaw2235
```

### 2. Usage 

URL to the product: http://lbaw2235.lbaw.fe.up.pt 

#### 2.1. Administration Credentials

| Username | Password |
| -------- | -------- |
| admin123@fe.up.pt | admin123 | 

#### 2.2. User Credentials

| Type          | Username  | Password |
| ------------- | --------- | -------- |
| basic account | basic123@fe.up.pt | basic123 | 
| event editor  | eventeditor123@fe.up.pt | eventeditor123 | 

### 3. Application Help

* A static [FAQ's](http://lbaw2235.lbaw.fe.up.pt/faq) page is provided to help our users to get the answer to the most common questions. 
* Forms show error messages to help them when they try to submit invalid information. For example, if you try to create an account with a username and/or email already taken, messages "The username has already been taken." and/or "The email has already been taken." will show up.

### 4. Input Validation

The data is validated in both frontend interface and backend. 

*Frontend Validation*

An example of our frontend validation, when creating a new account. Email field is checked if it corresponds to an email type string:

```
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user',
            'password' => 'required|string|min:6',
            'username' => 'required|string|min:3|max:60|unique:user'
        ]);
    }
```

*Backend Validation*

We used Laravel policies and the methods 'can' and 'authorize' to prevent unauthorized access and actions. Also, we used validators to validate the data before saving it in our database.

An example of our backend validation, when creating a new event:

```
    public function create()
    {
        Auth::user()->can('create', Event::class);

        return view('pages.event_create');
    }
```

### 5. Check Accessibility and Usability

Accessibility and usability test results:

* [Accessibility Test](https://git.fe.up.pt/lbaw/lbaw2223/lbaw2235/-/blob/main/Checklist_de_Acessibilidade_-_SAPO_UX.pdf)
* [Usability Test](https://git.fe.up.pt/lbaw/lbaw2223/lbaw2235/-/blob/main/Checklist_de_Usabilidade_-_SAPO_UX.pdf)

### 6. HTML & CSS Validation

[**HTML validation**](https://git.fe.up.pt/lbaw/lbaw2223/lbaw2235/-/blob/main/Html_Checker.pdf)
[**CSS validation**](https://git.fe.up.pt/lbaw/lbaw2223/lbaw2235/-/blob/main/Resultados_da_valida%C3%A7%C3%A3o_CSS.pdf)

### 7. Revisions to the Project

Since the requirements specification stage, seven user stories were added (US44, US45, US46, US47, US48, US49 and US50) to clarify some features included in the product. Some features weren´t implemented in the final product, due to various reasons.

### 8. Web Resources Specification

[OpenAPI](https://git.fe.up.pt/lbaw/lbaw2223/lbaw2235/-/blob/main/a7%20openapi.yaml)

### 9. Implementation Details

#### 9.1. Libraries Used 

No libraries were used. The [Laravel](https://laravel.com) framework was used in this product.

#### 9.2 User Stories

| US Identifier | Name    | Module | Priority                       | Team Members               | State  |
| ------------- | ------- | ------ | ------------------------------ | -------------------------- | ------ |
| US01 | Sign-up 							| M01 | High   | **Marcelo** | 100% |
| US02 | Sign-in 							| M01 | High   | **Marcelo** | 100% |
| US44 | Logout 							| M01 | High   | **Eduardo** | 100% |
| US03 | See Home 							| M02 | High   | **Marcelo** | 100% |
| US04 | See About 							| M05 | High   | **Diogo** | 100% |
| US45 | See FAQ							| M05 | High   | **Diogo** | 100% |
| US05 | Browse Public Events               | M02 | High   | **Eduardo** | 100% |
| US06 | View Public Event                  | M02 | High   | **Eduardo** | 100% |
| US07 | Search Events                      | M03 | High   | **Ricardo** | 50% |
| US09 | Create Event                       | M04 | High   | **Diogo** | 100% |
| US11 | Manage Own Events                  | M04 | High   | **Eduardo** | 100% |
| US12 | Manage Events Attended / to Attend | M06 | High   | **Ricardo** | 100% |
| US18 | Edit Event Details                 | M04 | High   | **Diogo** | 100% |
| US28 | View Event Messages                | M02 | Medium | **Ricardo** | 100% |
| US29 | Add Comments                       | M04 | Medium | **Marcelo** | 100% |
| US31 | Upload Files                       | M04 | Medium | **Ricardo** | 100% |
| US32 | Vote in Comments                   | M06 | Medium | **Ricardo** | 100% |
| US46 | Edit profile                       | M01 | High   | **Diogo** | 100% |
| US47 | View own profile                   | M01 | High   | **Ricardo** | 100% |
| US48 | Recover password                   | M01 | Low    | **Diogo** | 100% |
| US49 | Edit Comments                      | M04 | Medium | **Eduardo** | 100% |
| US50 | Delete Comments                    | M04 | Medium | **Marcelo** | 100% |
| US33 | View Attendees List                | M02 | Medium | **Marcelo** | 100% |
| US16 | Report Events                      | M04 | Low    | **Eduardo** | 90%  |
| US10 | Invite Users to Public Event       | M06 | High   | **Ricardo** | 100% |

---


## A10: Presentation

### 1. Product presentation

Helluva was developed in order to allow FEUP students to create, view and attend to events. This product allows users to easily interact with events by posting, commenting and voting on them.

Main features:

* Create an Account, login and edit your own profile.
* Text search events.
* Create events with it's location and date associated.
* Attend to events.
* Edit your own events.
* Create posts and comments on events.

URL to the product: http://lbaw2235.lbaw.fe.up.pt  

### 2. Video presentation

![Video](https://git.fe.up.pt/lbaw/lbaw2223/lbaw2235/-/raw/main/images/PRINT.png)

https://git.fe.up.pt/lbaw/lbaw2223/lbaw2235/-/blob/main/lbaw2235.mp4

---


## Revision history

Changes made to the first submission:

1. No changes were made yet.

***
GROUP2235, 02/01/2023

* Diogo Pinto, up201906067@up.pt
* Eduardo Duarte, up202004999@up.pt
* Marcelo Apolinário, up201603903@up.pt
* Ricardo Cruz, up202008789@up.pt

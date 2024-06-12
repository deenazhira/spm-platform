# Group 
1. Aina Najwa Maisarah Binti Mohamad Zulkarnain        (2212708)
2. Husna Nadhirah Binti Khairul Anwar                  (2211170)
3. Irdeena Zahierah Binti Zukipeli                     (2210496)
4. Ahmad Syameer Syafiq bin Zulkefli                   (2121797)

# SPM Student Learning Platform

## 1.0 Introduction

The SPM Student Learning Platform is a web application designed to support SPM students in their studies by providing a comprehensive and interactive online learning environment. Utilizing the Laravel MVC framework, the platform aims to offer a seamless user experience with features designed to meet the specific needs of SPM students.

With the rapid advancement of technology, traditional methods of learning are evolving, and online education is becoming increasingly popular. The SPM Student Learning Platform leverages this trend by providing a convenient and accessible platform for students to engage with their studies anytime, anywhere.

By integrating the Laravel MVC framework, the platform ensures scalability, security, and maintainability, allowing for seamless updates and enhancements over time. Through a user-friendly interface, students can navigate through various features effortlessly, making their learning journey intuitive and enjoyable.

The core features of the platform include:
- User Authentication
- Chapter Management
- Reflection Journals
- Profile Viewing

The SPM Student Learning Platform aims to empower students with the tools and resources they need to succeed academically while fostering a culture of lifelong learning and self-improvement. By harnessing the power of technology, the platform strives to revolutionize the way SPM students engage with their studies, paving the way for a brighter future.

## 2.0 Objectives

The main objectives of the SPM Student Learning Platform are:
1. To provide an easy-to-use platform for SPM students to access study materials.
2. To allow students to add, edit, and delete their reflections on what they have learned.
3. To enable students to view and manage their profiles and track their achievements.
4. To offer a secure login/logout system for user authentication.

## 3.0 Features and Functionalities

### User

#### i) Registration
- Allow new user to create an account
- Form to enter user details (username, email, password)
- Validate email and password
- Save user details to the database

#### ii) Login
- Allow registered user to log in
- Form to enter username and password
- Validate against database entries
- Redirect to the dashboard

#### iii) Logout
- Redirect to login page after logout

#### iv) Reset Password
- Allow user to reset their password if forgotten
- Form to confirm email address
- Send password reset link to user’s email
- Form to set a new password


### Subject

#### i) Add Subject
- Form to enter subject details (subject, topic)
- Save subject details to the database
- Display new subject in the subject list
  
#### ii) View List of Subject
- Display list of subject added
- Options to edit or delete
  
#### iii) Edit Subject Details
- Allow user to edit existing subject details
- Form to edit chapter details
- Update chapter details in the database after submission

#### iv) Delete Subject
- Pop-up box to confirm deletion
- Remove chapter from database


### Reflection Journal

#### i) Add
- Allow students to write their reflection on what they have learned
- Form to enter reflection details based on topic selection
- Save reflection to the database
- Display the new reflection in the list

#### ii) Edit
- Allow students to edit existing reflection details
- Form to edit reflection details
- Update reflection details in the database

#### iii) Delete
- Pop-up box to confirm deletion
- Remove reflection from the database

#### iv) View
- Display list of reflections written for every topic
- Options to view, edit, or delete


### Profile

#### i) View Profile Details
- Fetch student’s details from the database
- Display student’s details
- Options to edit or delete information

#### ii) View Achievements
- Allow students to see their achievements based on interactions with the platform
- Fetch achievements from the database
- Display list of achievements 

#### iii) View Registered Subjects
- Fetch registered subjects from the database
- Display list of registered subjects


## 4.0 ER Diagram
![ER Diagram](https://raw.githubusercontent.com/nadhirahanwar/WebApp-GroupProject-/main/ER%20DIAGRAM.png)


## 5.0 Sequence Diagram
![SEQUENCE Diagram](https://raw.githubusercontent.com/nadhirahanwar/WebApp-GroupProject-/main/SEQ%20DIAGRAM.jpg)

## 6.0 Project System Captured Screen

Mainpage
![mainpage](https://github.com/deenazhira/spm-platform/assets/172114212/a0326d44-cb08-4445-acb2-369afc3e9518)

Mainpage (Cont)
![mainpage 2](https://github.com/deenazhira/spm-platform/assets/172114212/4f582797-93d9-4d87-aca7-7868762be23a)

Mainpage (Cont)
![mainpage 3](https://github.com/deenazhira/spm-platform/assets/172114212/673097ec-a2d7-4545-b44c-07891c640815)

Register
![register](https://github.com/deenazhira/spm-platform/assets/172114212/3f661d14-1bf0-467c-9ff0-e5c6c8b15658)

Login
![login](https://github.com/deenazhira/spm-platform/assets/172114212/69a7a033-509b-4766-a0fd-81b28ce5b2a7)

Dashboard
![dashboard](https://github.com/deenazhira/spm-platform/assets/172114212/5fdef291-cea0-403b-b2b9-494e6c6f657a)

Manage (Profile and Logout)
![profile-logout](https://github.com/deenazhira/spm-platform/assets/172114212/8251f3e1-7d8e-48ac-9ebf-905ec05e4bf2)

Profile
![profile 1](https://github.com/deenazhira/spm-platform/assets/172114212/3640ad1f-1cc8-481f-882d-16c4af25b924)

Profile(Cont)
![profile 2](https://github.com/deenazhira/spm-platform/assets/172114212/2f9cfa62-505b-4cdd-bab1-99477122d6c8)

Sidebar
![Side bar](https://github.com/deenazhira/spm-platform/assets/172114212/4a23cdcb-4114-44fa-aafc-efd0ed51ddc9)

Reflections
![reflection](https://github.com/deenazhira/spm-platform/assets/172114212/56445437-8bfb-4d1c-9764-55c63c8b6658)

Subjects
![Subjects](https://github.com/deenazhira/spm-platform/assets/172114212/c400c543-a7cf-425c-9f22-403f72f0aa89)


## 7.0 Challenges/Difficulties
1. Challenge to debug all errors that happened when trying to install and run the codes
2. Difficulties in connecting the model, view and controllers
3. Difficulties in understanding the use github.

## 8.0 REFERENCES
  
1. SPMFlix. (2024, May 3). SPMFlix - Malaysia’s Largest Free Online Learning Platform
https://www.spmflix.com/ 

2. GeeksforGeeks. (2024, February 27). How to design ER diagrams for project management Software. GeeksforGeeks. https://www.geeksforgeeks.org/how-to-design-er-diagrams-for-project-management-software 

3. Drexel University's School of Education. (n.d.). Benefits of Online and Virtual Learning. Retrieved from https://drexel.edu/soe/resources/student-teaching/advice/benefits-of-online-and-virtual-learning/




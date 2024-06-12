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

## 7.0 Challenges/Difficulties
1. 

## 8.0 REFERENCES
  
1. SPMFlix. (2024, May 3). SPMFlix - Malaysia’s Largest Free Online Learning Platform
https://www.spmflix.com/ 

2. GeeksforGeeks. (2024, February 27). How to design ER diagrams for project management Software. GeeksforGeeks. https://www.geeksforgeeks.org/how-to-design-er-diagrams-for-project-management-software 

3. Drexel University's School of Education. (n.d.). Benefits of Online and Virtual Learning. Retrieved from https://drexel.edu/soe/resources/student-teaching/advice/benefits-of-online-and-virtual-learning/




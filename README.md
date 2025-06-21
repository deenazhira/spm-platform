<<<<<<< HEAD
# Web Application Security Enhancement Report

## Group Members
1. Husna Nadhirah Binti Khairul Anwar - 2211170
2. Irdeena Zahierah Binti Zukipeli - 2210496

## **Title:** SPM Learning Platform 

## Introduction
The Student Learning Platform is a web application designed to support students in their studies by providing a comprehensive and interactive online learning environment. Utilizing the Laravel MVC framework, the platform aims to offer a seamless user experience with features designed to meet the specific needs of SPM students.

With the rapid advancement of technology, traditional methods of learning are evolving, and online education is becoming increasingly popular. The Student Learning Platform leverages this trend by providing a convenient and accessible platform for students to engage with their studies anytime, anywhere.

## Objectives of the Enhancements
- To protect user data from unauthorized access
- To apply strong security best practices
- To reduce vulnerabilities reported by OWASP ZAP

### 1.0 Vulnerability Report 
**i) Before Enhancement**

**Tool Used:** OWASP ZAP  
**Scan Type:** Active  
**Date of Scan:** 2025-06-20

The scan detected 8 issues, with 2 medium, 4 low and 2 informational priority alerts.

| Vulnerability     | Risk Level | Confidence Level | 
|-------------------|------------|------------------|
| CSP header not set     | Medium     | High             | 
| Missing anti-clickjacking header              | Medium     | Medium           | 
| Big Redirect Detected (Potential Sensitive Information Leak)     | Low     | Medium             | 
| Cookie No HttpOnly Flag | Low       | Medium             | 
| Server Leaks Information via "X-Powered-By" HTTP Response Header Field(s) | Low | Medium |
| X-Content-Type-Options Header Missing | Low | Medium |
| Information Disclosure - Suspicious Comments | Informational | Low |
| Modern Web Application | Informational | Medium |

![image](https://github.com/user-attachments/assets/419365bf-2977-4532-af3c-14ce0b60f622)
=======
# spm-platform
>>>>>>> 218459cccdc1890a17bcc997b414fe4f9c48f615

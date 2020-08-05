# Extention Vass\RegisterCustomer


### Magento 2 extension, that modifies the customer registration flow next way:

#### Once the customer has been successfully registered:


* Removes whitespaces from the customer first name.

* Logs customer data (current date and time, email, first and last name) to a separate log file (/var/log/customer_registered.log).

* Sends an email with the customer data (first and last name, email) to the Customer Support email address configured in Magento.


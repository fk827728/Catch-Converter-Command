# Order Data Converter Command

## Author Information

- Name: Louis Fang
- Contact Number: 0420686268
- Email Address: fk827728@gmail.com

## Description

- Order Data Converter Command provides a converter to convert jsonl format file to csv, xml or yaml file and upload the converted file to Github server and share it in Github Page. Then validate the file and send email with attachment.

## Installation Instructions

- Download the repository
- Run `composer install`
- Uncomment `extension=curl` in php.ini in order to execute `curl_exec`
- Run `php .\bin\console app:convert "https://s3-ap-southeast-2.amazonaws.com/catch-code-challenge/challenge-1/orders.jsonl" data\test.csv [test@gmail.com]` command in project root directory. Email address is an optional parameter.
- Check console output for executing information and check `data/` folder for the converted file.
- If the file name uploaded to Github is duplicated, command will pop up a tip. Please change a file name and retry because the uploaded files are not removed on Github when uploading.

## Requirement Documents

- documents/Coding Challenge.pdf

## Sample Data

- data/orders.jsonl
- data/sample.csv
- data/sample.xml
- data/sample.yaml

## Development Platform

- PHP 8.1.8
- Symfony 6.1.2

## Design Pattern

- Simple Factory Pattern
- Strategy Pattern
- Dependency Injection Pattern

## Other Technologies

- Generator
- PHP Coding Standards
- PHPUnit
- Regular Expression
- Dynamic Class Instantiation
- REST API
- CURL

## System Design
- Above 3 design patterns are used in the application which make the whole system clear and be in line with the SOLID principle:
  - Single Responsibility Principle: EmailService, GeocodingService, UploadService are responsible for their own functionality.
  - Open Closed Principle: Converter and Validator can be extended and all the modifications are in the specific child classed.
  - Liskov Substitution Principle: CsvConverter is a type of Converter.
  - Interface Segregation Principle: ConverterInterface and ValidatorInterface are separate.
  - Dependency Inversion Principle: Converter depends on DataInterface instead of specific class.

- Although `Symfony\Component\Serializer` can be used to convert the file, there will be several defects: (I also have the code which we can discuss if you are interested in.)
  - If the file is read line by line, the converted data contains the title every time which needs to be removed. 
  - If the file is not read line by line, the memory will be out if the file is too huge.

- Generator is used to read the file and to handle the memory usage.

- All the codes pass PHP Coding Standards checking

- There are 2 test cases in tests/Service/ folder. In order to test function `ConvertOrderObjectToOrderData`, I changed this function from `private` to `public`.

## Project Tree
```
ConverterCommand
├─ .env
├─ .env.test
├─ .gitignore
├─ bin
│  ├─ console
│  └─ phpunit
├─ composer.json
├─ composer.lock
├─ config
│  ├─ bundles.php
│  ├─ packages
│  │  ├─ cache.yaml
│  │  ├─ framework.yaml
│  │  ├─ mailer.yaml
│  │  └─ routing.yaml
│  ├─ preload.php
│  ├─ routes
│  │  └─ framework.yaml
│  ├─ routes.yaml
│  └─ services.yaml
├─ data
│  ├─ orders.jsonl
│  ├─ sample.csv
│  ├─ sample.xml
│  └─ sample.yaml
├─ docker-compose.override.yml
├─ documents
│  └─ Coding Challenge.pdf
├─ public
│  └─ index.php
├─ README.md
├─ src
│  ├─ Command
│  │  └─ ConverterCommand.php
│  ├─ Controller
│  │  └─ .gitignore
│  ├─ Kernel.php
│  └─ Util
│     ├─ Converter
│     │  ├─ ConverterFactory.php
│     │  ├─ ConverterInterface.php
│     │  ├─ CsvConverter.php
│     │  ├─ XmlConverter.php
│     │  └─ YamlConverter.php
│     ├─ Data
│     │  ├─ DataInterface.php
│     │  └─ OrderData.php
│     ├─ Service
│     │  ├─ EmailService.php
│     │  ├─ GeocodingService.php
│     │  ├─ OrderFileConverterService.php
│     │  ├─ OrderFileValidatorService.php
│     │  ├─ StringService.php
│     │  └─ UploadService.php
│     └─ Validator
│        ├─ CsvValidator.php
│        ├─ ValidatorFactory.php
│        ├─ ValidatorInterface.php
│        ├─ XmlValidator.php
│        └─ YamlValidator.php
├─ symfony.lock
└─ tests
   ├─ bootstrap.php
   └─ Service
      ├─ CsvConverterTest.php
      └─ OrderFileConverterServiceTest.php

```
<p align="center">
  <img src="https://edishack.com/images/edilaravel/edi-laravel-3.png" width="400">
</p>


## EDI-Laravel package
The full package for the EDI Laravel project

EDI-Laravel is a Laravel based EDI framework. This package can be installed in a new project or existing Laravel project. 

EDI-Laravel works by managing the EDI files, and making the necessary database entries. 

EDI Types can be fully automated, or run manually


### Features of EDI-Laravel
- Can be used with ANSII X12, EDIFACT, TRADACOMS orebXML
- Create or read any EDI Transaction Set
- Complete management of your EDI Files
- Automate generating and sending files
- Automatically reads incoming files
- FTP, FPTS, SFPT, HTTP, HTTPS, AS2 Connectors
- Extremely low resource usage
- Manage ASCII, EDIFACT and custom files with the same interface
- Easily create, test and automate any Transaction set with limited programming 
- Reads an EDI file into json, can then be used to input into database or any other data input method

```
Data

{
    "FunctionalIdentifierCode": null,
    "GroupAcknowledgeCode": null,
    "NumberOfTransactionSetsIncluded": 0,
    "NumberOfReceivedTransactionSets": 0,
    "NumberOfAcceptedTransactionSets": 0,
    "DataInterchangeControlNumber": null,
    "InterchangeSenderID": "SENDER1",
    "InterchangeReceiverID": "AMAZON",
    "ApplicationSenderCode": "SENDER1-210,
    "ApplicationReceiverCode": "AMAZON-210",
    "DetailDataSet": [
        {
            "TransactionSetIdentifier": "210",
            "TransactionSetControlNumber": 1,
            "B3-01-ShipmentQualifier": "",
            "B3-02-InvoiceNumber": "INV-2035",
            "B3-03-ShipmentIdentificationNumber": "BOL-123",
            "B3-04-ShipmentMethodOfPayment": "PP",
            "B3-05-WeightUnitCode": "L",
            "B3-06-Date": "240316",
            "B3-07-NetAmountDue": "73125",
            "B3-08-CorrectionIndicator": "",
            "B3-09-DeliverDate": "240317",
            "B3-10-DateTimeQualifier": "010",
            "B3-11-StandardCarrierAlphaCode": "SCAC",
            "B3-12-Date": "240316",
            "B3-13-TariffServiceCode": "",
            "B3-14-TransportationTermsCode": "",
            "N9Array": [
                {
                    "N9-011-ReferenceIdentificationQualifier": "BM",
                    "n9-02-ReferenceIdentification": "BOL123"
                },
                {
                    "N9-011-ReferenceIdentificationQualifier": "CN",
                    "n9-02-ReferenceIdentification": "INV2035"
                }
            ]
        }
    ],
    "ediTypeId": 68,
} 
   
```


### Please Note - EDI Shack is working hard on EDI Laravel but EDI Laravel is not ready for public use yet. There is NO public documentation.

#### Benefits of using Laravel
•Simple, fast routing engine.
•Powerful dependency injection container.
•Multiple back-ends for session and cache storage.
•Expressive, intuitive database ORM.
•Database agnostic schema migrations.
•Robust background job processing.
•Real-time event broadcasting.

EDI-Laravel is accessible, powerful, and provides tools required for large, robust EDI applications.

##### Learning EDI-Laravel

EDI-Laravel will have the most extensive and thorough documentation and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

##### EDI-Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding EDI-Laravel development. 

##### Premium Partners
- **[EDI Shack](https://edishack.com/)**

##### Contributing

Thank you for considering contributing to the EDI-Laravel framework! The contribution guide can be found in the EDI-Laravel documentation.

##### Security Vulnerabilities

If you discover a security vulnerability within EDI-Laravel, please send an e-mail to Brad Gies via rbgies1 at yahoo dot com. All security vulnerabilities will be promptly addressed.

##### License

The EDI-Laravel framework is open-sourced software licensed under the MIT license.


## Installation
EDI-Laravel is installed via composer. 

### Donate with [PayPal](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=)

Developing EDI is expensive, decent programmers who know EDI charge from US$45-US$110 per hour. If you think this package is useful and saves you a lot of work, perhaps you would donate a small percentage of the money saved. You will sleep much better, and donating a small amount would be very cool.

[![Paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=)

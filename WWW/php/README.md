#ST_API

###This application is in Pre-Alpha.

**ST_API.php**
This file is a convenient library loader. You are only required to include this one file and the entire library will be made available to you.

**APIVARS.php**
This file is currently used to house global variables which are accessed throughout the API.

**funcs.php**
This file provides helper functions which do not necessarily belong to an object but, are used to reduce the number of replicated lines throughout pages on the site.

**dataobjects**
These files describe the properties of objects utilized by ServiceTrade. This is also where the HttpRequest object and all child *Method*Request objects. (Get, Post, Delete...)

**executors**
These files remap or wrap endpoints on the ServiceTrade API. They provide the ability to interact with ServiceTrade. They may utilize a DataObject to perform their functions. They may also return a DataObject as part of their output.

**accesspoints**
These are endpoints which wrap an executor or executors into logical processes. They can be called by JavaScript in the browser and perform the required executions to retrieve the requested dataobjects.

A brief description of this is as follows.

The login page does not use an "access point" to log the user into ServiceTrade. The login page itself will invoke a Login object which will set _SESSION variables upon successful login.

Once a user visits the homepage, JavaScript sends a "GET" request to an "access point", in this case 'appointment.php', which will invoke the Appointments executor. It will retreive a list of all scheduled appointments assigned to the current logged in user.

It will then parse the list of appointments for "ServiceRequests" and automatically request the full "Asset" from the "Assets" executor.

Once the list of appointments has had the "Asset" objects expanded, it is returned as a JSON object to JavaScript on the Homepage which handles construction of the Appointment List Content Boxes.
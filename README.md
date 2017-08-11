# Magento2 Patchworks Connector

The Magento2 Patchworks Connector, provides extensions to the standard 
Magento2 REST API to give a few extra features that come in handy when
importing/exporting data from Magento2.

#Installation
To install and enable the module, run the following commands from the root location of your Magento2 installation:
1. composer require patchworks/magento2-connector
2. php bin/magento module:enable Patchworks_Connector

#Note
This module is still in first release beta.

#About Patchworks
http://www.patchworks.co.uk/<br />
Patchworks middleware helps integrate data between different business
systems. Check out the website above for more information.

#Key Features

<b>Reindex (GET)</b><br />
/rest/V1/patchworks/reindex?index={indexName}<br />
Allows a remote system to trigger a reindex process via the REST API.

<b>REST API Error Report</b><br />
/rest/V1/patchworks/apierror?report={reportNumber}<br />
Allows the remote retrieval of the webapi-X error from the logs folder.

<b>Image Search (GET)</b><br />
/rest/V1/patchworks/imagesearch?sku={sku}<br />
Allows a remote system to search the /media/import folder for image
references that have a file name matching the SKU passed in the URL. 
Matching images are then returned as an array for use in external systems.

<b>Mass Stock Update (PUT)</b><br />
/rest/V1/patchworks/stocklevels/<br />
Allowance for external systems to post stock levels on mass, the module
then updates the database directly with the new stock level data. 

When sending data to this function it expects the following format:

```json
{
    'stock_items': {
        'sku': 'ABC123',
        'qty': 49
    },
    {
        'sku': 'FJ3FF',
        'qty': 23
    }
}
```

<b>Mass Stock Export (GET)</b><br />
/rest/V1/patchworks/stocklevels/<br />
Allows the export of all stocklevels from the Magento system in a single call.
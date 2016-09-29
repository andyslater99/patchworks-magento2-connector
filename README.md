# Magento2 Patchworks Connector

The Magento2 Patchworks Connector, provides extensions to the standard 
Magento2 REST API to give a few extra features that come in handy when
importing/exporting data from Magento2.

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

<b>Image Search (GET)</b><br />
/rest/V1/patchworks/imagesearch?sku={sku}<br />
Allows a remote system to search the /media/import folder for image
references that have a file name matching the SKU passed in the URL. 
Matching images are then returned as an array for use in external systems.

<b>Mass Stock Update (PUT)</b><br />
/rest/V1/patchworks/massstock/<br />
Allowance for external systems to post stock levels on mass, the module
then updates the database directly with the new stock level data.
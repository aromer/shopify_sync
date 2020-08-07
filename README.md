# Shopify Order Archive

This app is a proof of concept and is not intended for production use.

## Purpose
This app uses the Laravel framework and is implemented as a private app for a Shopify Store. It uses the Shopify REST API to query for Orders. It archives these orders in a local database and update the local database with a diff of new or modified orders since the last sync. The Orders are stored as an archive, and therefore stores the entire JSON representation of the order, unaltered, as opposed to fully converting it into an Eloquent model.

## Usage
Loading this app will query Shopify for Orders modified since the most recent record. Shopify must be configured in the .env file.

## Limitations
Authentication is not included in the app at this time, and should not be used with production data. Edge cases currently throw uncaught exceptions, which should be caught, logged, and turned into a user facing error message without crashing the application.

## Future Improvements
* Add authentication
* Add exception handling
* Move the synchronization code out of the controller
* Create a mapper to convert between the JSON order and Order model
* Update the API to use GuzzleHTTP instead of Curl.
* Add support for Shopify Webhooks and monitor with a Laravel job to keep the Orders table in sync without needing to make the query each time the orders page is loaded.
* Use the GraphQL API instead of REST
* Add a frontend framework and integrate Polaris
* Add unit tests
* Consider using existing composer packages that implement the Shopify API instead of reimplementing it.

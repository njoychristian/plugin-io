# Release Notes for IO

## v1.4.3 (2017-08-25)

### Removed

- The unused route `/guest` and `GuestController` have been removed.

## v1.4.2 (2017-08-23)

### Fixed

- When accessing the order overview page with an expired session, a 404 page is shown instead of a twig error.

## v1.4.1 (2017-08-11)

### Added

- The order confirmation link in the order overview of the back end can now also be interpreted.
- `ContactMailService` now accepts a parameter to submit a copy of the contact form to the sender.

### Fixed

- Due to an error, prices of cross-selling items were not displayed. This has been fixed.
- In case of an invalid order confirmation link, a 404 page will be displayed instead of a Twig error.

## v1.4.0 (2017-08-09)

### Added

- The logic and the route `/wish-list` has been added to display a wish list in the online store. **Note:** In order for the migration of the data base table to run correctly, the standard client must be activated and the plugin deployed. After deployment the standard client can be deactivated.
- The logic and the route `/contact` has been added to display a contact page in the online store. 
- The `ContactMailService` has been added to process the sending of customer requests via the contact page of the online store.
- A method has been added in the `BasketService` to get the quantity of items in the shopping cart.
- The `NotificationService` has been extended to correctly display error messages in the front-end.
- The link in the order confirmation email now forwards to the order confirmation page of Ceres.

### Fixed

- The language selection in the header of the online store displays languages again.

### Removed

- The logic for item stock has been removed from the `ItemController`. This information is now contained in the `result fields` of ElasticSearch.

## v1.3.2 (2017-07-26)

### Added

- The phone number can now be saved in the `CustomerService`.

### Fixed

- The performance of the order confirmation page has been improved.
- The item images on the order confirmation page are now displayed correctly.

## v1.3.1 (2017-07-21)

### Added

- Order properties of the **Text** type are now processed in the `BasketService` and the `OrderItemBuilder`.
- The route `io/localization/language` has been added. This route can be used to set the language of the online store.

## v1.3.0 (2017-07-13)

### Added

- IO now provides data concerning cross-selling and tags for item lists.
- Templates can now be cached.
- The academic title can now be saved in the `CustomerService`.
- A new event `LocalizationChanged` has been added.
- Multiple conditions for changing the payment method in the **My account** area have been added. The **Allow customer to change the payment method** setting must be activated in the Ceres configuration. Additionally, the order must not be paid yet. The order status must be less than 3.4, or when the order was created the same day the order status must be 5 or less than 3.4.

### Changed

- The online store search will now use the **AND** operator. This replaces the **OR** search that was previously used.
- Editing additional address fields has been optimised in the `CustomerService`.

### Fixed

- Only those item images activated for a client will be displayed in the respective online store.

## v1.2.10 (2017-07-05)

### Added

- The `getCheckoutPaymentDataList` method was added in the `CheckoutService`, to return the `sourceUrl` of a payment plugin.
- It is now possible to set up complex item sorting for the category view and the search by using the recommended sorting options.
- The result of a requested item also contains the formatted item price.

### Changed

- Address fields that are deactivated in the configuration of Ceres but for which validation is activated, will not be validated in the online store anymore.

## v1.2.9 (2017-06-30)

### Fixed

- The translation in the list of payment methods wasn't displayed, when clicking on **Change payment method** in the checkout. This has been fixed.
- In the `TemplateService` the method `isCurrentTemplate` has been added to dynamically request the current template.

## v1.2.8 (2017-06-29)

### Added

- A payment method can be changed subsequently for an order in the **My account** area if this feature is enabled in the payment method.

### Changed

- Variations that are out of stock cannot be added to the shopping cart anymore.
- When selecting a variation that is out of stock the customer will be forwarded to the next variation with stock.

### Fixed

- Due to an error, a deleted address was not removed from the address list. This has been fixed.
- Due to an error the address could not be edited when ordering as a guest. This has been fixed.

## v.1.2.7 (2017-06-21)

### Fixed

- During registration, when the customer enters an invoice address, the entered address is not automatically saved as the delivery address.

## v1.2.6 (2017-06-14)

### Fixed

- Due to an error, the validator for invoice and delivery addresses for the country of delivery **United kingdom** did not work properly. This has been fixed.

## v1.2.5 (2017-06-08)

### Added

- Countries of delivery and online store settings are now loaded from the cache to improve the overall performance.

### Fixed

- Due to an error the default country of delivery has not been set. This has been fixed.

## v1.2.4 (2017-06-02)

### Added

- A Twig filter for sorting an object by a given key has been added.
- Validation of the address form for the delivery country **United Kingdom**

## v1.2.3 (2017-05-19)

### Added

- The date of birth and the VAT number entered during the address input will now be saved with the address.
- Added a twig filter for variation images.
- A corresponding template plugin can now be specified in the configuration of IO.
- Address validation based on the specified template plugin.

### Fixed

- Items will only be returned when item texts have been saved in the selected store language.

## v1.2.2 (2017-05-11)

## Fixed

- Suggested search results created by the auto-complete feature are now taking into account the grouping of variations.

## v1.2.1 (2017-05-08)

## Fixed

- Minor bug fixes and improvements.

## v1.2.0 (2017-04-28)

### Fixed

- Registrations with an email address for which an account already exists are no longer possible.
- Breadcrumbs are now also working correctly in the single item view.

## v1.1.1 (2017-04-24)

### Added

- Logic for the item list of last seen items

### Fixed

- Grouping of variations in the category item list and on the search result page
- Sorting by item name in the category item list and on the search result page

## v1.1.0 (2017-04-12)

### Added

- TemplateService: `isCategoryView` method added to check if current page is category page.
- Support for new category logic in Ceres.

## v.1.0.4

### Fixed

- An error that occurred when opening the order confirmation page has been fixed

## v1.0.3 (2017-03-24)

### Added

- Filter functionality via facets
- Rendered Twig templates can now be retrieved via REST
- New Twig functions: `trimNewLines` and `formatDateTime` 
- New method in the **CategoryService**: `getChildren()`
to get all subcategories

### Changed

- Routing was updated and extended: Old store URLs can now be processed and displayed in **Ceres**. The URL structure was optimised from `/{itemName}/{itemId}/{variationId}` to `/{category}/{subcategory}/.../{itemName}-{itemId}-{variationId}` 

## v1.0.2 (2017-03-06)

### Fixed

- Fixed an error when accessing the category view and single item view.
- Fixed an error with items showing up in a category which they weren‘t linked with.
- Fixed an error with other plugin routes being overwritten by the 404 route of IO.

## v1.0.1 (2017-02-22)

### Fixed

- Fixed an error that occurred when activating additional store languages. When [adding](https://developers.plentymarkets.com/dev-doc/template-plugins#design-lang) new language files to the `resources/lang` folder and compiling the files with [Gulp](https://developers.plentymarkets.com/dev-doc/template-plugins#gulp-ceres), the template will be displayed in the selected language.

## v1.0.0 (2017-02-20)

### Features
**IO** offers a variety of logic functions for a plentymarkets online store and serves as an interface between plentymarkets and the following online store pages:
- Homepage
- Category view
- Item view
- Shopping cart
- Checkout
- Order confirmation
- Login and registration
- Guest order page
- **My account** page
- static pages (e.g. terms and conditions, legal disclosure etc.)

Furthermore, **IO** allows you to load additional content with the help of template containers.

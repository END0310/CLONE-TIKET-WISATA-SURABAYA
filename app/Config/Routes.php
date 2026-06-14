<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

$routes->get('/', 'Home::index');
$routes->get('/destinations', 'Destination::index');
$routes->get('/destinations/detail/(:num)', 'Destination::detail/$1');

$routes->get('/booking/create/(:num)', 'Booking::create/$1');
$routes->post('/booking/store', 'Booking::store');
$routes->get('/booking/detail/(:segment)', 'Booking::detail/$1');

$routes->get('/payment/(:segment)', 'Payment::index/$1');
$routes->post('/payment/process', 'Payment::process');
$routes->get('/payment/success/(:segment)', 'Payment::success/$1');
$routes->get('/payment/failed/(:segment)', 'Payment::failed/$1');

$routes->get('/ticket/(:segment)', 'Ticket::show/$1');
$routes->get('/ticket/download/(:segment)', 'Ticket::download/$1');

$routes->get('/validate-ticket', 'TicketValidation::index');
$routes->post('/validate-ticket/check', 'TicketValidation::check');
$routes->post('/validate-ticket/use', 'TicketValidation::useTicket');

$routes->get('/cancellation', 'Cancellation::index');
$routes->post('/cancellation/request', 'Cancellation::requestCancel');
$routes->get('/cancellation/status/(:segment)', 'Cancellation::status/$1');

$routes->get('/faq', 'Page::faq');
$routes->get('/contact', 'Contact::index');
$routes->post('/contact/send', 'Contact::send');

$routes->get('/login', 'Auth::login');
$routes->post('/login/process', 'Auth::process');
$routes->get('/login/google', 'Auth::google');
$routes->get('/login/google/callback', 'Auth::googleCallback');
$routes->get('/logout', 'Auth::logout');

$routes->get('/user/dashboard', 'User\Dashboard::index');

$routes->get('/admin/dashboard', 'Admin\Dashboard::index');
$routes->get('/admin/destinations', 'Admin\DestinationAdmin::index');
$routes->get('/admin/destinations/create', 'Admin\DestinationAdmin::create');
$routes->post('/admin/destinations/store', 'Admin\DestinationAdmin::store');
$routes->get('/admin/destinations/edit/(:num)', 'Admin\DestinationAdmin::edit/$1');
$routes->post('/admin/destinations/update/(:num)', 'Admin\DestinationAdmin::update/$1');
$routes->post('/admin/destinations/delete/(:num)', 'Admin\DestinationAdmin::delete/$1');
$routes->get('/admin/bookings', 'Admin\BookingAdmin::index');
$routes->get('/admin/payments', 'Admin\PaymentAdmin::index');
$routes->get('/admin/tickets', 'Admin\TicketAdmin::index');
$routes->get('/admin/contact-messages', 'Admin\ContactMessageAdmin::index');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
Route::get('/category/{category}', [CategoryController::class, 'showCategory'])->name('category.show');

// Show contact form
Route::get('/contact', [ContactController::class, 'showContactForm'])->name('contact');

// Handle contact form submission
Route::post('/contact', [ContactController::class, 'sendContactForm'])->name('send.contact.form');

// Route::get('/home', function () {
//     return view('home'); // Or redirect()->route('your.main.page')
// })->name('home');
Route::get('/orders', [OrderController::class, 'showOrders'])->name('orders.show');
Route::post('/cancel-product', [OrderController::class, 'cancelProduct'])->name('orders.cancel');

// Show canceled orders for a logged-in user
Route::get('/cancel-orders', [OrderController::class, 'showCanceledOrders'])->name('cancel-orders.show');

// Define the route for order success
Route::get('/order/success', [PaymentController::class, 'orderSuccess'])->name('order.success');
Route::post('/place-order', [PaymentController::class, 'placeOrder'])->name('placeOrder');

Route::get('/payment', [PaymentController::class, 'showPaymentPage'])->name('payment.page');
Route::post('/payment', [PaymentController::class, 'processPayment'])->name('payment.process');

// Admin Dashboard Route
Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

Route::get('/deliveries', [DeliveryController::class, 'index'])->name('deliveries.index');
// Route to display the order status page
Route::get('/order-status', [OrderStatusController::class, 'index'])->name('order-status');

// Route to confirm delivery
Route::post('/order-status/confirm', [OrderStatusController::class, 'confirmDelivery'])->name('order-status.confirm');

// Show all expenses
Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');

// Store a new expense
Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');

// Delete an expense
Route::delete('/expenses/{id}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');

// Show the form to edit an expense
Route::get('/expenses/{id}/edit', [ExpenseController::class, 'edit'])->name('expenses.edit');

// Update the expense
Route::put('/expenses/{id}', [ExpenseController::class, 'update'])->name('expenses.update');

// Show the empty update product form
Route::get('/update-product', [ProductController::class, 'showUpdateForm'])->name('product.update.form');

// Fetch the product by ID and show the form with prefilled details
Route::post('/fetch-product', [ProductController::class, 'fetchProduct'])->name('product.fetch');

// Submit the update product form
Route::post('/update-product/{id}', [ProductController::class, 'update'])->name('product.update');
Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');

Route::get('/add-product', [ProductController::class, 'showAddProductForm'])->name('add.product');
Route::post('/add-product', [ProductController::class, 'store'])->name('store.product');

// Excel import route
Route::post('/import-excel', [ProductController::class, 'importExcel'])->name('import.excel');


// Category management routes (if needed)
Route::get('/add-category', [CategoryController::class, 'showAddCategoryForm'])->name('add.category');
Route::post('/add-category', [CategoryController::class, 'storeCategory'])->name('store.category');

// Route to show the list of users with search functionality
Route::get('/admin/users', [PageController::class, 'index'])->name('admin.users');
Route::post('/admin/users/block-unblock', [PageController::class, 'blockUnblock']);
// Route to show the details of a specific user
Route::get('/user-details/{id}', [PageController::class, 'show'])->name('user.details');


// Public Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/signup', [SignupController::class, 'showSignupForm'])->name('signup.form');
Route::post('/signup', [SignupController::class, 'processSignup'])->name('signup.submit');

// User Dashboard route
Route::get('/user/dashboard', function () {
    return view('user.dashboard'); // Your user dashboard view
})->name('user.dashboard');

// Shop Routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index'); // Show list of products
Route::get('/shopnow', [ShopController::class, 'showShopNowPage'])->name('shopnow'); // Ensure this method is defined in ShopController

// Route to add a product to the cart (make sure this matches the URL in your blade view)
Route::get('/shopnow/add-to-cart/{product_id}', [ShopController::class, 'addToCart'])->name('addToCart');
Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');  // Show cart items
Route::post('/cart/update-quantity/{productId}', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');  // Update cart item quantity
Route::get('/cart/remove/{productId}', [CartController::class, 'removeFromCart'])->name('cart.remove');  // Remove item from cart
Route::post('/cart/place-order', [CartController::class, 'placeOrder'])->name('cart.placeOrder');  // Place the order

// Route::get('/payment', [PaymentController::class, 'showPaymentPage'])->name('payment');
// Route::post('/process-payment', [PaymentController::class, 'processPayment'])->name('process_payment');
Route::get('/confirm-order', function () {
    return view('confirm_order');
})->name('confirm_order');

// Route::get('cart', [CartController::class, 'showCart'])->name('cart');
// Route::post('place-order', [CartController::class, 'placeOrder']);
// Route::get('remove/{id}', [CartController::class, 'removeFromCart']);
// Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout'); // Show checkout page
// Route::post('/cart/checkout', [CartController::class, 'placeOrder'])->name('cart.placeOrder'); // Place order after checkout

// Admin Routes
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login.form'); // Admin login form
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login'); // Admin login action

// Admin Dashboard Route (Mapped to admin_home.blade.php)
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// Admin Sales Routes
Route::get('/admin/today-sales', [AdminController::class, 'todaySales'])->name('admin.today-sales'); // Today's sales data
Route::get('/admin/total-sales', [AdminController::class, 'totalSales'])->name('admin.total-sales'); // Total sales data

// Admin Customers and Products Routes
Route::get('/admin/all-customers', [AdminController::class, 'allCustomers'])->name('admin.allCustomers'); // List of all customers
Route::get('/admin/total-products', [AdminController::class, 'totalProducts'])->name('admin.totalProducts'); // List of total products

// Admin Customer Details Route
Route::get('/admin/customer-details/{username}', [AdminController::class, 'customerDetails'])->name('admin.customer.details'); // Customer details page

// Product Routes
Route::get('/product/{name}', [ProductController::class, 'show'])->name('product.show');
Route::get('/product-details', [ProductController::class, 'show'])->name('product.details');
Route::get('/admin/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/admin/products/update/{id}', [ProductController::class, 'updateView'])->name('products.updateView');
//Route::put('/admin/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/admin/products/delete/{id}', [ProductController::class, 'delete'])->name('products.delete');
Route::get('/admin/products/edit/{id}', [ProductController::class, 'showEditForm'])->name('products.edit');
Route::put('/admin/products/update/{id}', [ProductController::class, 'updateProduct'])->name('products.update');

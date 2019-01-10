<?php
/*
 **  -- Auth Routes
 ** thes rotes used to login and register and other authenticaiton tasks
 **
*/
Auth::routes();

/*
 **  -- Public Routes
 ** thes rotes not need login - and - not need any roles
 **
*/
Route::group(['middleware' => 'web'],function(){
  Route::get('/', 'StartController@start')->name('start');
});



/*
 **  -- Logined Routes
 ** thes rotes need Login
 **
*/
Route::group(['middleware' => 'auth'],function(){
  // Home Page Route
  Route::get('/home','Main\HomeController@index')->name('home');

  // Profile Routes
  Route::get('/my-profile','Main\ProfileController@my_profile')->name('profile.my_profile');
  Route::post('/edit-my-profile-info','Main\ProfileController@edit_profile')->name('profile.edit_profile');
  Route::post('/edit-my-profile-pass','Main\ProfileController@edit_password')->name('profile.edit_password');
  Route::get('/delete-account','Main\ProfileController@delete')->name('profile.delete');
  Route::post('/delete-account-execute','Main\ProfileController@delete_exe')->name('profile.delete.execute');

  // Bag Routes
  Route::get('/my-bag','Main\BagController@index')->name('bag.index');
  Route::get('/my-bag-empty','Main\BagController@empty_bag')->name('bag.empty');
  Route::get('/my-bag-item-delete/{id}','Main\BagController@item_delete')->name('bag.item_delete');

  // Browse Routes
  Route::get('/browse/{slug}','Main\BrowseController@index')->name('browse.index');
  Route::get('/browse/item/{id}','Main\BrowseController@item_view')->name('browse.item_view');
  Route::get('/browse/subject-review/{subject_slug}','Main\BrowseController@sub_view')->name('browse.sub_view');
  Route::get('/browse-all','Main\BrowseController@browse_all')->name('browse.all');

  // Library Routes
  Route::get('/library','Main\LibraryController@index')->name('library');
  Route::get('/library/lib/{department_slug}/{stage_id}','Main\LibraryController@lib')->name('library.lib');
  Route::get('/library/sub/{subject_slug}/{depID}/{stgID}','Main\LibraryController@sub')->name('library.sub');


  // Search Routes
  Route::get('/search','Main\SearchController@index')->name('search.index');
  Route::get('/search/search','Main\SearchController@search')->name('search.search');

  // Order Routes
  Route::get('/order','Main\OrderController@order_view')->name('order');
  Route::post('/order-sending','Main\OrderController@order_send')->name('order.send');

  // Like Comment Bag Routes - With Ajax in lb.js File
  Route::post('/item-love','Main\LCController@love')->name('love');
  Route::post('/item-bag','Main\LCController@bag')->name('bag');
  Route::post('/comment-add','Main\LCController@add_comment')->name('comments.add');
  Route::get('/comment-delete/{cid}','Main\LCController@delete_comment')->name('comments.delete');

  // Friends Routes
  Route::get('/friends','Main\FriendsController@index')->name('friends');

  // About Routes
  Route::get('/about',function(){ return view('main.about.about'); })->name('about');
});
// -----------------------------------------------------------




/*
 ** -- Upload Items Routes
 ** thes rotes need Login and Owner or Administrator or Uploader Role
 **
*/
Route::group(['prefix' => 'upload', 'middleware' => ['auth','role'], 'roles' => ['Owner','Administrator','Uploader']],function(){
  // Upload Routes
  Route::get('/upload','Main\UploadController@index')->name('upload.index');
  Route::get('/upload/in-my-stage','Main\UploadController@upload_in_my_stage')->name('upload.upload_in_my_stage');
  Route::post('/upload/o-uploading','Main\UploadController@o_upload')->name('upload.o_upload');
  Route::post('/upload/u-uploading','Main\UploadController@u_upload')->name('upload.u_upload');
  Route::post('/upload/edit-item-execute','Main\UploadController@item_edit_execute')->name('item.item_edit_execute');
  Route::get('/upload/item-delete/{id}','Main\UploadController@item_delete')->name('item.delete');
  Route::get('/upload/edit-item/{id}','Main\UploadController@item_edit_show')->name('item.item_edit_show');

  // Users Items
  Route::get('/my-items','Main\ProfileController@my_items')->name('profile.my_items');
});
// -----------------------------------------------------------





// ============================= DASHBOARD ROUTES ====================================

/*
 * This Group For Owner Role Only
 *
 */
Route::group(['prefix' => 'dashboard','middleware' =>['auth','role'],'roles' =>['Owner','Owner','Owner']],function(){

  // Managers Route
  Route::get('/managers','Dashboard\UsersController@managers')->name('managers');
  Route::get('/managers/make-new-owner/{id}','Dashboard\UsersController@make_owner')->name('users.make_owner');
  Route::get('/managers/make-new-administrator/{id}','Dashboard\UsersController@make_administrator')->name('users.make_administrator');
  Route::get('/managers/make-new-uploader/{id}','Dashboard\UsersController@make_uploader')->name('users.make_uploader');
  Route::get('/managers/make-user/{id}','Dashboard\UsersController@make_user')->name('users.make_user');


  // Settings Route
  Route::get('/settings','Dashboard\SettingsController@index')->name('settings');
  Route::post('/settings/{id}/update','Dashboard\SettingsController@update')->name('settings.update');
  Route::get('/settings/{id}/destroy','Dashboard\SettingsController@destroy')->name('settings.destroy');
  Route::post('/settings/store','Dashboard\SettingsController@store')->name('settings.store');


});
// --------------------------------------------------------------------------------------



/*
 * This Group For Owner and  Administrator Role
 *
 */
Route::group(['prefix' => 'dashboard', 'middleware' => ['auth','role'], 'roles' => ['Owner','Administrator','Administrator'] ],function(){

     // Route to Show Dashboard Home Page
     Route::get('/home','Dashboard\HomeController@index')->name('dashboard_home');


     // Users Route
     Route::get('/users/{showState}','Dashboard\UsersController@index')->name('users.index');
     Route::get('/users/delete/{uid}','Dashboard\UsersController@delete')->name('users.delete');
     Route::get('/users/block/{uid}','Dashboard\UsersController@block')->name('users.block');
     Route::get('/users/state/block-all-users','Dashboard\UsersController@block_all')->name('users.block_all');
     Route::get('/users/active/{uid}','Dashboard\UsersController@active')->name('users.active');
     Route::get('/users/state/active-all-users','Dashboard\UsersController@active_all')->name('users.active_all');

     // Departments Routes
     Route::get('/departments','Dashboard\DepartmentsController@index')->name('departments');
     Route::get('/departments/delete/{slug}','Dashboard\DepartmentsController@delete')->name('departmenst.delete');
     Route::post('/department/new-department','Dashboard\DepartmentsController@new_department')->name('department.new_department');
     Route::get('/department-edit/{slug}','Dashboard\DepartmentsController@edit_show')->name('departments.edit_show');
     Route::post('/departments-edit-save','Dashboard\DepartmentsController@edit_save')->name('departments.edit_save');


     // Stages Route
     Route::get('/stages','Dashboard\StagesController@index')->name('stages');
     Route::post('/stage/new-stage','Dashboard\StagesController@new_stage')->name('stages.new_stage');
     Route::get('/stages/delete/{id}','Dashboard\StagesController@delete')->name('stages.delete');
     Route::get('/stages/edit-stage/{id}','Dashboard\StagesController@edit_show')->name('stages.edit_show');
     Route::post('/stages/edit_exe','Dashboard\StagesController@edit')->name('stages.edit_exe');


     // Categorys Route
     Route::get('/categories','Dashboard\CategorysController@index')->name('categorys');
     Route::post('/categories/new-categorys','Dashboard\CategorysController@new_category')->name('categorys.new_category');
     Route::get('/categories/delete/{slug}','Dashboard\CategorysController@delete')->name('categorys.delete');
     Route::get('/categories/edit/{slug}','Dashboard\CategorysController@edit_show')->name('categorys.edit_show');
     Route::post('/categories/edit-save','Dashboard\CategorysController@edit_save')->name('categorys.edit_save');

     // Years Route
     Route::get('/years','Dashboard\YearsController@index')->name('years');
     Route::get('/years/delete/{year}','Dashboard\YearsController@delete')->name('years.delete');
     Route::post('/years/new-year','Dashboard\YearsController@new_year')->name('years.new_year');

     // Subjects Route
     Route::get('/subjects-start','Dashboard\SubjectsController@start')->name('subjects.start');
     Route::get('/subjects-brows/{dept}/{stg}','Dashboard\SubjectsController@brows')->name('subjects.brows');
     Route::get('/subjects/add-new-subject','Dashboard\SubjectsController@add_view')->name('subjects.add_view');
     Route::get('/subjects/edit/{slug}','Dashboard\SubjectsController@edit_view')->name('subjects.edit_view');
     Route::post('/subjects-add-execute','Dashboard\SubjectsController@add')->name('subjects.add');
     Route::post('/subjects-edit-execute','Dashboard\SubjectsController@edit')->name('subjects.edit');
     Route::get('/subjects/view/{slug}','Dashboard\SubjectsController@view_subject')->name('subjects.view_subject');
     Route::get('/subjects/delete/{slug}','Dashboard\SubjectsController@delete')->name('subjects.delete');

     // Items Route
     Route::get('/items/by/{showState}','Dashboard\ItemsController@index')->name('items.index');
     Route::get('/items/ud/{view}','Dashboard\ItemsController@upload_edit_forms_view')->name('items.upload_edit_view');
     Route::post('/items/up-execute','Dashboard\ItemsController@upload')->name('items.upload');
     Route::post('/items/edit-execute','Dashboard\ItemsController@edit')->name('items.edit');
     Route::get('/items/delete/{id}','Dashboard\ItemsController@delete')->name('items.delete');

     // Orders Route
     Route::get('/orders','Dashboard\OrdersController@index')->name('orders.index');
     Route::get('/orders/delete/{id}','Dashboard\OrdersController@delete')->name('orders.delete');
});
// ------------------------------------------------------------------------------------------------

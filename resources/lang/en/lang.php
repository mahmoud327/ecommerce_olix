<?php

return [

    'dashboard'                                         => 'Dashboard',
    /************** table ***************/
    'action'                                            => 'Action',

    /**************** account ****************/
    'add_account'                                       => 'Add Account',
    'account_name'                                      => 'Name',
    'page_title_of_account'                             => 'Account - Page',

    // validation
    'account_required'                                  => 'account name is required',
    'account_unique'                                    => 'account name alredy exist',

    /**************** sub account ****************/
    'add_sub_account'                                   => 'Add Sub Account',
    'sub_account_name'                                  => 'Name',
    'parent_account'                                    => 'Parent Account',
    'page_title_of_sub_account'                         => 'Sub Account - Page',

    // validation
    'sub_account_required'                              => 'sub account name is required',
    'sub_account_unique'                                => 'sub account name alredy exist',
    'account_id_required'                               => 'parent account name is required',

    //////////////////////orgniazation//////////////////////////////
    'orgniazation'                                      => 'orgniazation',
    'add_orgniazation'                                  => 'Add orgniazation',
    'edit'                                              => 'edit organization',
    'delete_all'                                        => 'delete all',
    'orgniazation_name'                                 => 'NAME',
    'orgniazation_image'                                => 'IMAGE',
    'orgniazation_name_ar'                              => 'name arabic',
    'orgniazation_name_en'                              => 'name english ',

    'action'                                            => 'action',
    'save'                                              => 'save',
    'close'                                             => 'close',
    'delete'                                            => 'delete',
    'edit'                                              => 'edit',
    'message'                                           => 'message',
    ///////////////////////////////////////////////////////////
    'organize_name_ar_required'                         => 'organize arabic is required',
    'organize_name_en_required'                         => 'organize arabic is required',
    'organize_image_required'                           => 'image required',
    'organize_image_image'                              => 'image must be image',

    ////////////////product//////////////////////////////

    'products'                                          => 'products',
    'details'                                           => 'details',
    'description'                                       => 'description',

    'quantity'                                          => 'quantity',
    'link'                                              => 'link',
    'discount'                                          => 'discount',
    'note'                                              => 'note',

    'note_ar'                                           => 'note arabic',
    'note_en'                                           => 'note english',
    'discount'                                          => 'discount',
    'add_product'                                       => 'Add product',
    'product_name'                                      => 'NAME',

    'image'                                             => 'IMAGE',
    'uploads'                                           => 'uploads',
    'phone'                                             => 'phone',
    'price'                                             => 'price',
    'contact'                                           => 'contact',
    'personal'                                          => 'personal',
    'company'                                           => 'company',
    'chat'                                              => 'chat',
    'all'                                               => 'all',
    'back'                                              => 'back',
    ///////valdation

    'name_ar_required'                                  => 'name arabic is required',
    'name_en_required'                                  => 'name english is required',

    'discount_required'                                 => 'discount is required',
    'price_required'                                    => ' price is required',
    'link_required'                                     => 'link is required',
    'phone_required'                                    => 'phone is required',
    'contact_required'                                  => 'contact is required',
    'description_ar_required'                           => 'description arabic is required ',
    'description_en_required'                           => 'description english is required ',

    'note_ar_required'                                  => 'note arabic is required',
    'note_en_required'                                  => 'note english is required',

    'quantity_required.'                                => 'quantity is required',
    'document_required'                                 => 'document is required',
    'quantity_numeric'                                  => 'quantity is numeric',
    'price_numeric'                                     => 'price is numeric',
    'discount_numeric'                                  => 'discount is numeric',

    'status'                                            => 'status',
    'pendding'                                          => 'pendding',
    'approve'                                           => 'approve',
    'finsih'                                            => 'finsih',
    'created_at'                                        => 'created_at',

    ///////////////////////////////////////////
    'last_categories_required'                          => 'category  is required',
    'last_categories'                                   => 'last_categories ',

    /**************** filter ****************/
    'add_filter'                                        => 'Add Filter',
    'filter_name'                                       => 'Name',
    'page_title_of_filter'                              => 'Filter - Page',
    'edit_filter'                                       => 'Edit Filter',

    // validation
    'filter_name_en_required'                           => 'filter name_en is required',
    'filter_name_ar_required'                           => 'filter name_ar is required',
    'sub_account_in_filter_required'                    => 'sub account is required',

    /**************** sub filter ****************/
    'add_sub_filter'                                    => 'Add Sub Filter',
    'sub_filter_name'                                   => 'Name',
    'page_title_of_sub_filter'                          => 'Sub filter - Page',
    'edit_sub_filter'                                   => 'Edit Sub Filter',

    // validation
    'sub_filter_name_en_required'                       => 'sub filter name_en is required',
    'sub_filter_name_ar_required'                       => 'sub filter name_ar is required',

    /**************** recurring filter ****************/
    'recurring_filter_name'                             => 'name',
    'add_recurring_filter'                              => 'create filter',
    'page_title_of_recurring_filter'                    => 'page filter',

    // validation
    'recurring_filter_name_ar_required'                 => 'name arabic filter is required',
    'recurring_filter_name_en_required'                 => 'name english filter is reqiured',
    'recurring_filter_sub_account_required'             => 'يجب عليك اختيار اسم صلاحية واحدة علي الاقل',
    'recurring_filter_last_categories_required'         => 'category_last is required',
    'recurring_filter_last_recurring_category_required' => 'category is required',

    /**************** recurring sub filter ****************/
    'recurring_filter_name'                             => 'name',
    'add_recurring_sub_filter'                          => 'add filter recuring',
    'page_title_of_recurring_sub_filter'                => 'page add filter',

    // validation
    'recurring_sub_filter_name_ar_required'             => 'يجب عليك ادخال اسم الفلتر الابن باللغة العربية',
    'recurring_sub_filter_name_en_required'             => 'يجب عليك ادخال اسم الفلتر الابن باللغة الانجليزية',
    'recurring_filter_sub_account_required'             => 'يجب عليك اختيار اسم صلاحية واحدة علي الاقل',
    'recurring_filter_last_categories_required'         => 'يجب عليك اختيار قسم',
    'recurring_filter_last_recurring_category_required' => 'يجب عليك اختيار قسم',

    ///user

    'user_name'                                         => 'name',
    'user_email'                                        => 'email',
    'user_mobile'                                       => 'mobile',
    'upgrade'                                           => 'upgrade',
    'user_privilage'                                    => 'privilage',

    ///request upgrade

    'upgrade_request_reason'                            => 'the Reason',
    'upgrade_request_Close'                             => 'Close',
    'upgrade_request_Save'                              => 'Save',
    'upgrade_request_rejected'                          => 'rejected',
    'upgrade_request_accept'                            => 'accept',
    'upgrade_request_reason_rejected'                   => 'reason rejected',

    'upgrade_request_phone'                             => 'phone',
    'upgrade_request_Orgnization_Name'                  => 'Orgnization Name',
    'upgrade_request_Account'                           => 'The Account He Want To Be',
    'upgrade_request_Category'                          => 'Category He Want To See',

    'upgrade_request_Status'                            => 'Status',
    'upgrade_request_note'                              => 'note',

    'model_featured'                                    => 'The :model has been marked as featured successfully.',
    'model_created'                                     => 'The :model has been created successfully.',
    'model_updated'                                     => 'The :model has been updated successfully.',
    'model_added'                                       => 'The :model has been added successfully.',
    'model_deleted'                                     => 'The :model has been deleted successfully.',

    'cities'                                            => [
        'cairo' => 'Cairo',
    ],
];

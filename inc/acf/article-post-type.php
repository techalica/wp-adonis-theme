<?php
$save_format = 'url';
$library     = 'all';

$tab_basic                  = fields()->tab('Basic');
$name                       = fields()->text('Name')->required(true);
$summary                    = fields()->textarea('Summary');
$height                     = fields()->number('Height');
$age                        = fields()->range('Age');
$email_address              = fields()->email('Email address');
$website                    = fields()->url('Website');
$password                   = fields()->password('Password');


$tab_content                = fields()->tab('Content');
$image                      = fields()->image('Image');
$resume                     = fields()->file('Resume/CV');
$about                      = fields()->wysiwyg('About');
$embed                      = fields()->oembed('Embed');
$gallery                    = fields()->gallery('Gallery');

$tab_choice                 = fields()->tab('Choice');
$marital_status             = fields()->select('Marital Status')
                              ->choice('Single', 'single')
                              ->choice('Married', 'married')
                              ->choice('Divorced', 'divorced');

$dietary_preference         = fields()->checkbox('Dietary Preference')
                              ->choice('Vegetarian', 'vegetarian')
                              ->choice('Non-Vegetarian', 'non_vegetarian')
                              ->choice('Gluten Free', 'gluten_free');

$gender                     = fields()->radio('Gender')
                              ->choices([
                                  'male' => 'Male',
                                  'female' => 'Female',
                              ]);

$religion                   = fields()->button_group('Religion')
                               ->choice('Muslim', 'muslim')
                               ->choice('Jew', 'jew')
                               ->choice('Christian', 'christian');

$do_practice                = fields()->boolean('Do you practice?');




$tab_relational             = fields()->tab('Relational');

$favorite_link              = fields()->link('Favorite Link');

$favorite_post              = fields()->post('Favorite Post');

$favorite_page              = fields()->page('Favorite Page');

$relationship               = fields()->relationship('Relationship');

$taxonomy                   = fields()->taxonomy('Taxonomy');

$user                       = fields()->user('User');




$tab_jquery                 = fields()->tab('jQuery');

$favorite_color             = fields()->color_picker('Favorite Color');

$birth_date                 = fields()->date_picker('Birth Date');

$birth_time                 = fields()->time_picker('Birth Time');

$memorable_date_time        = fields()->date_time_picker('Memorable Date Time');



$tab_layout                 = fields()->tab('Layout');


$message                    = fields()->message('Message')->message('This is a message');

$accordion                  = fields()->message('Accordion');

$experience                 = fields()->group('Experience')
                                ->sub_field( 'company', fields()->text( 'Company' ) )
                                ->sub_field( 'start_date', fields()->date_picker( 'Start Date' ) )
                                ->sub_field( 'end_date', fields()->date_picker( 'End Date' ) )
                                ->sub_field( 'working', fields()->boolean( 'Currently Working' ) );


$education                  = fields()->repeater('Education')
                                ->sub_field( 'school', fields()->text( 'School' ) )
                                ->sub_field( 'class', fields()->text( 'Class' ) )
                                ->sub_field( 'start_date', fields()->date_picker( 'Start Date' ) )
                                ->sub_field( 'end_date', fields()->date_picker( 'End Date' ) );


$flexible_content           = fields()->flexible_content('Flexible Content');



$tab_computed               = fields()->tab('Computed');

$move_abroad                = fields()->boolean('Do you want to move abroad?');

$settle_abroad              = fields()->boolean('Do you want to settle abroad?');

$country                    = fields()->select('Country')
                                        ->choices([
                                            'canada' => 'Canada',
                                            'australia' => 'Australia',
                                            'england' => 'England',
                                        ])
                                        ->conditional_logic()
                                            ->condition($move_abroad, true, '==')
                                            ->condition($settle_abroad, true,'==');


//--Registering Metabox-----------------------------------------------------------//

$metabox = Metabox::instance();

$metabox->title( "Personal Information" )
        ->key( 'personal-information' )
        ->high()
        ->label_left()
        ->location()
        ->post_type()
        ->value( 'article' );

$metabox->hide()->all()->permalink( false )->page_attributes( false );

$metabox->metabox()->fields( get_defined_vars() );

$metabox->register();

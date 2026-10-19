<?php

class MyStrReplaceOperator
{
    /*!
     Constructor. PHP 7 deprecated, and PHP 8 removed, constructors named after
     their class: without __construct() the operator list stayed empty and the
     template engine reported "Object problem with operator".
    */
    function __construct()
    {
        $this->Operators = array( 'ezstr_replace' );
    }

    /*!
     The old constructor name, kept for code that called it directly.
    */
    function MyStrReplaceOperator()
    {
        self::__construct();
    }

    /*!
     Returns the operators in this class.
    */
    function operatorList()
    {
        return $this->Operators;
    }

    /*!
     \return true to tell the template engine that the parameter list
    exists per operator type, this is needed for operator classes
    that have multiple operators.
    */
    function namedParameterPerOperator()
    {
        return true;
    }

    /*!
     The first operator has two parameters, the other has none.
     See eZTemplateOperator::namedParameterList()
    */
    function namedParameterList()
    {
        return array(
                      'ezstr_replace' => array('search'  => array( 'type' => 'string',
                                                                     'required' => true,
                                                                     'default' => '' ),
                                                'replace' => array( 'type' => 'string',
                                                                     'required' => true,
                                                                     'default' => '' ),
                                                'subject' => array( 'type' => 'string',
                                                                     'required' => false,
                                                                     'default' => null )
                                            ) );
    }

    /*!
     Executes the needed operator(s).
     Checks operator names, and calls the appropriate functions.
    */
    function modify( $tpl, $operatorName, $operatorParameters, $rootNamespace, $currentNamespace, &$operatorValue, $namedParameters )
    {
        switch ( $operatorName )
        {
            case 'ezstr_replace':
            {
                // subject is optional: an explicit parameter wins, otherwise
                // fall back to the piped operator value ({$var|ezstr_replace(...)}).
                $subject = $namedParameters['subject'] !== null
                    ? $namedParameters['subject']
                    : $operatorValue;

                $search  = $namedParameters['search'];
                $replace = $namedParameters['replace'];

                // Support comma-separated lists for multi-replace convenience.
                // e.g. {ezstr_replace('foo,bar', 'baz,qux', $subject)}
                if ( is_string( $search ) && strpos( $search, ',' ) !== false )
                {
                    $searchParts = array_map( 'trim', explode( ',', $search ) );

                    if ( is_string( $replace ) && strpos( $replace, ',' ) !== false )
                    {
                        $replace = array_map( 'trim', explode( ',', $replace ) );
                    }
                    // else: single scalar replace works fine with an array search.

                    $search = $searchParts;
                }

                $operatorValue = str_replace( $search, $replace, $subject );
            } break;
        }
    }

    /// \privatesection
    var $Operators;
}

?>
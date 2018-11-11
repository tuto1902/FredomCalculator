@extends('layouts.app')

@section('page_name', 'Financial Freedom Wizard')
@section('body_class', 'nav-md')
@section('scripts')
    <script src="/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
    <script src="/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <script src="/vendors/validator/validator.js"></script>

    <script language="JavaScript">
        var init_SmartWizard = function () {

            if( typeof ($.fn.smartWizard) === 'undefined'){ return; }
            console.log('init_SmartWizard');

            $('#wizard').smartWizard({
                onLeaveStep: Wizard.validateStepCallBack,
                onFinish: Wizard.validateStepCallBack
            });

            $('#wizard_verticle').smartWizard({
                transitionEffect: 'slide'
            });

            $('.buttonNext').addClass('btn btn-success');
            $('.buttonPrevious').addClass('btn btn-primary');
            $('.buttonFinish').addClass('btn btn-default');

        };
        var init_validator = function () {};

        var Items = function () {

            return {
                init: function () {
                    $(document).on('click', '.add-button', function(ev) {
                        ev.preventDefault();
                        var itemsContainer = $(this).parents('#items-container');
                        var currentItem = $(this).parents('.row:first');
                        if($(currentItem.find('input')[0]).val() != '' && $(currentItem.find('input')[1]).val() != ''){
                            var newEntry = $(currentItem.clone()).appendTo(itemsContainer);

                            $(newEntry.find('input')[0]).val('');
                            $(newEntry.find('input')[1]).val('').inputmask('$ 999,999,999', { numericInput: true });
                            $('#wizard').smartWizard('fixHeight');

                            $('#wizard').find('.row.item').each(function (index) {
                                $($(this).find('input')[0]).attr('name', 'item['+ index +'][label]');
                                $($(this).find('input')[1]).attr('name', 'item['+ index +'][amount]');
                            });

                            itemsContainer.find('.row:not(:last) .add-button')
                                    .removeClass('add-button').addClass('remove-button')
                                    .removeClass('btn-success').addClass('btn-danger')
                                    .html('<i class="fa fa-minus"></i>');
                        }
                    });

                    $(document).on('click', '.remove-button', function(ev) {
                        ev.preventDefault();
                        $(this).parents('.row:first').remove();
                        $('#wizard').smartWizard('fixHeight');
                        $('#wizard').find('.row.item').each(function (index) {
                            $($(this).find('input')[0]).attr('name', 'item['+ index +'][label]');
                            $($(this).find('input')[1]).attr('name', 'item['+ index +'][amount]');
                        });
                        return false;
                    });
                }
            }
        }();

        var Wizard = function () {
            var validateStep = function (step) {
                var valid = true;
                $('#step-'+step).find('.row.item:not(:last)').each(function () {
                    valid = valid * validator.checkField.apply($(this).find('input')[0]);
                    valid = valid * validator.checkField.apply($(this).find('input')[1]);
                });
                var last = $('#step-'+step).find('.row.item:last');
                if ($(last.find('input')[0]).val() != '') {
                    validator.unmark($(last.find('input')[0]));
                    valid = valid * validator.checkField.apply($(last.find('input')[1]))
                }
                else if ($(last.find('input')[1]).val() != '') {
                    validator.unmark($(last.find('input')[1]));
                    valid = valid * validator.checkField.apply($(last.find('input')[0]))
                }
                else {
                    validator.unmark($(last.find('input')[0]));
                    validator.unmark($(last.find('input')[1]));
                }
                return valid;
            };
            return {
                validateStepCallBack: function (obj, context) {
                    var valid =  validateStep(context.fromStep);
                    if (context.fromStep == 3 && valid) {
                        $('#wizard_form').submit();
                    }
                    return valid;
                }
            };
        }();

        $(document).on('ready', function () {
            validator.defaults.classes.item = 'form-group';
            validator.defaults.alerts = false;
            Items.init();
        });
    </script>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Financial Freedom Calculator</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form id="wizard_form" method="post" action="/items" class="form-horizontal">
                        {{ csrf_field() }}
                        <div id="wizard" class="form_wizard wizard_horizontal">
                            <ul class="wizard_steps">
                                <li>
                                    <a href="#step-1">
                                        <span class="step_no">1</span>
                                        <span class="step_descr">
                                            Financial Stability<br />
                                            <small>Your basic monthly expenses</small>
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#step-2">
                                        <span class="step_no">2</span>
                                <span class="step_descr">
                                                  Financial Independence<br />
                                                  <small>Monthly amount to support your current lifestyle</small>
                                              </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#step-3">
                                        <span class="step_no">3</span>
                                <span class="step_descr">
                                                  Financial Freedom<br />
                                                  <small>Any luxury items and their monthly cost</small>
                                              </span>
                                    </a>
                                </li>
                            </ul>

                            <div id="step-1">
                                <div class="row">
                                    <div class="col-md-2 col-md-offset-2">
                                        <h3>Monthly Expenses</h3>
                                    </div>
                                </div>
                                <div id="items-container">
                                    <div class="row item">
                                        <div class="col-md-2 col-sm-2"></div>
                                        <div class="col-md-2 col-sm-2 col-xs-4 form-group">
                                            <input type="text" name="items[0][label]" required="required" class="form-control" placeholder="Item Label" value="Rent / Mortgage">
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-4 form-group">
                                            <input type="text" name="items[0][amount]" required="required" class="form-control" placeholder="$" data-inputmask="'mask' : '$ 999,999,999', 'numericInput': true">
                                        </div>
                                        <div class="col-md-1 col-sm-1 col-xs-4 form-group">
                                            <button type="button" class="btn btn-danger remove-button"><i class="fa fa-minus"></i></button>
                                        </div>
                                        <input type="hidden" name="items[0][goal_id]" value="1">
                                    </div>
                                    <div class="row item">
                                        <div class="col-md-2 col-sm-2"></div>
                                        <div class="col-md-2 col-sm-2 col-xs-4 form-group">
                                            <input type="text" name="items[1][label]" required="required" class="form-control" placeholder="Item Label" value="Food">
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-4 form-group">
                                            <input type="text" name="items[1][amount]" required="required" class="form-control" placeholder="$" data-inputmask="'mask' : '$ 999,999,999', 'numericInput': true">
                                        </div>
                                        <div class="col-md-1 col-sm-1 col-xs-4 form-group">
                                            <button type="button" class="btn btn-danger remove-button"><i class="fa fa-minus"></i></button>
                                        </div>
                                        <input type="hidden" name="items[1][goal_id]" value="1">
                                    </div>
                                    <div class="row item">
                                        <div class="col-md-2 col-sm-2"></div>
                                        <div class="col-md-2 col-sm-2 col-xs-4 form-group">
                                            <input type="text" name="items[2][label]" required="required" class="form-control" placeholder="Item Label" value="Utilities">
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-4 form-group">
                                            <input type="text" name="items[2][amount]" required="required" class="form-control" placeholder="$" data-inputmask="'mask' : '$ 999,999,999', 'numericInput': true">
                                        </div>
                                        <div class="col-md-1 col-sm-1 col-xs-4 form-group">
                                            <button type="button" class="btn btn-danger remove-button"><i class="fa fa-minus"></i></button>
                                        </div>
                                        <input type="hidden" name="items[2][goal_id]" value="1">
                                    </div>
                                    <div class="row item">
                                        <div class="col-md-2 col-sm-2"></div>
                                        <div class="col-md-2 col-sm-2 col-xs-4 form-group">
                                            <input type="text" name="items[3][label]" required="required" class="form-control" placeholder="Item Label" value="Transportation">
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-4 form-group">
                                            <input type="text" name="items[3][amount]" required="required" class="form-control" placeholder="$" data-inputmask="'mask' : '$ 999,999,999', 'numericInput': true">
                                        </div>
                                        <div class="col-md-1 col-sm-1 col-xs-4 form-group">
                                            <button type="button" class="btn btn-danger remove-button"><i class="fa fa-minus"></i></button>
                                        </div>
                                        <input type="hidden" name="items[3][goal_id]" value="1">
                                    </div>
                                    <div class="row item">
                                        <div class="col-md-2 col-sm-2"></div>
                                        <div class="col-md-2 col-sm-2 col-xs-4 form-group">
                                            <input type="text" name="items[4][label]" required="required" class="form-control" placeholder="Item Label" value="Insurance">
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-4 form-group">
                                            <input type="text" name="items[4][amount]" required="required" class="form-control" placeholder="$" data-inputmask="'mask' : '$ 999,999,999', 'numericInput': true">
                                        </div>
                                        <div class="col-md-1 col-sm-1 col-xs-4 form-group">
                                            <button type="button" class="btn btn-danger remove-button"><i class="fa fa-minus"></i></button>
                                        </div>
                                        <input type="hidden" name="items[4][goal_id]" value="1">
                                    </div>
                                    <div class="row item">
                                        <div class="col-md-2 col-sm-2"></div>
                                        <div class="col-md-2 col-sm-2 col-xs-4 form-group">
                                            <input type="text" name="items[5][label]" required="required" class="form-control" placeholder="Item Label">
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-4 form-group">
                                            <input type="text" name="items[5][amount]" required="required" class="form-control" placeholder="$" data-inputmask="'mask' : '$ 999,999,999', 'numericInput': true">
                                        </div>
                                        <div class="col-md-1 col-sm-1 col-xs-4 form-group">
                                            <button type="button" class="btn btn-success add-button"><i class="fa fa-plus"></i></button>
                                        </div>
                                        <input type="hidden" name="items[5][goal_id]" value="1">
                                    </div>
                                </div>
                            </div>
                            <div id="step-2">
                                <div class="row">
                                    <div class="col-md-2 col-md-offset-2">
                                        <h3>Your Income Sources</h3>
                                    </div>
                                </div>
                                <div id="items-container">
                                    <div class="row item">
                                        <div class="col-md-2 col-sm-2"></div>
                                        <div class="col-md-2 col-sm-2 col-xs-4 form-group">
                                            <input type="text" name="items[6][label]" required="required" class="form-control" placeholder="Item Label" value="Salary">
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-4 form-group">
                                            <input type="text" name="items[6][amount]" required="required" class="form-control" placeholder="$" data-inputmask="'mask' : '$ 999,999,999', 'numericInput': true">
                                        </div>
                                        <div class="col-md-1 col-sm-1 col-xs-4 form-group">
                                            <button type="button" class="btn btn-danger remove-button"><i class="fa fa-minus"></i></button>
                                        </div>
                                        <input type="hidden" name="items[6][goal_id]" value="2">
                                    </div>
                                    <div class="row item">
                                        <div class="col-md-2 col-sm-2"></div>
                                        <div class="col-md-2 col-sm-2 col-xs-4 form-group">
                                            <input type="text" name="items[7][label]" required="required" class="form-control" placeholder="Item Label">
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-4 form-group">
                                            <input type="text" name="items[7][amount]" required="required" class="form-control" placeholder="$" data-inputmask="'mask' : '$ 999,999,999', 'numericInput': true">
                                        </div>
                                        <div class="col-md-1 col-sm-1 col-xs-4 form-group">
                                            <button type="button" class="btn btn-success add-button"><i class="fa fa-plus"></i></button>
                                        </div>
                                        <input type="hidden" name="items[7][goal_id]" value="2">
                                    </div>
                                </div>
                            </div>
                            <div id="step-3">
                                <div class="row">
                                    <div class="col-md-2 col-md-offset-2">
                                        <h3>Your Financial Dreams</h3>
                                    </div>
                                </div>
                                <div id="items-container">
                                    <div class="row item">
                                        <div class="col-md-2 col-sm-2"></div>
                                        <div class="col-md-2 col-sm-2 col-xs-4 form-group">
                                            <input type="text" name="items[8][label]" required="required" class="form-control" placeholder="Luxury Item Name">
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-4 form-group">
                                            <input type="text" name="items[8][amount]" required="required" class="form-control" placeholder="$" data-inputmask="'mask' : '$ 999,999,999', 'numericInput': true">
                                        </div>
                                        <div class="col-md-1 col-sm-1 col-xs-4 form-group">
                                            <button type="button" class="btn btn-success add-button"><i class="fa fa-plus"></i></button>
                                        </div>
                                        <input type="hidden" name="items[8][goal_id]" value="3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

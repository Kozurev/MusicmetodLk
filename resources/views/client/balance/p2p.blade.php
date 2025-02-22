@extends('layouts.app', ['partition' => 'balance', 'page' => 'balance.p2p.index'])

@section('content')
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="kt-menu__link-bullet flaticon-users"><span>&nbsp;</span></i>
            </span>
                <h3 class="kt-portlet__head-title">
                    {{ __('pages.p2p-title') }}
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="alert alert-outline-brand alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                        Можете пополнить баланс переведя сумму на карту одному из наших преподавателей. Каждый из предложенных получателей имеет статус самозанятого. <br/>
                        После перевода по указанным платежным данным дождитесь подтверждения получения средств преподавателем и Ваш баланс будет пополнен. <br/>
                        В случае возникновения проблем или долгого отсутствия подтверждения оплаты от получателя обратитесь к менеджеру.
                    </div>
                </div>
            </div>

            <form action="{{ route('balance.makeDeposit') }}" method="GET" id="p2pChooseForm">
                @csrf
                <input type="hidden" name="without_p2p" value="1">
                <input type="hidden" name="amount" value="{{ $amount }}">
                <div class="form-group form-group-marginless">
                    <label>{{ __('pages.p2p-choose-receiver') }}</label>
                    <div class="row">
                        @php /** @var $receiver \App\DTO\P2P\ReceiverDataDTO */ @endphp
                        @foreach($receivers as $i => $receiver)
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <label class="kt-option">
                                    <span class="kt-option__control">
                                        <span class="kt-radio">
                                            <input type="radio"
                                                   name="receiver"
                                                   class="p2p_receiver"
                                                   value="{{ $receiver->getPaymentDataDTO()->getReceiverId() }}"
                                                   data-fio="{{ $receiver->getTeacherDTO()->getFio() }}"
                                                   data-card_number="{{ $receiver->getPaymentDataDTO()->getCardNumber() }}"
                                                   data-phone_number="{{ $receiver->getPaymentDataDTO()->getPhoneNumber() }}"
                                                   data-comment="{{ $receiver->getPaymentDataDTO()->getComment() }}"
                                                   @if(!$i) checked @endif
                                            >
                                            <span></span>
                                        </span>
                                    </span>
                                    <span class="kt-option__label">
                                    <span class="kt-option__head">
                                        <span class="kt-option__title">
                                            {{ $receiver->getTeacherDTO()->getFio() }}
                                        </span>
                                        <span class="kt-option__focus">
                                        </span>
                                    </span>
                                    <span class="kt-option__body">
                                        @if (null !== $receiver->getPaymentDataDTO()->getCardNumber())
                                            <hr/>
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-6 col-md-6 col-sm-12 text-left">{{ __('pages.p2p-card-number') }}</label>
                                                <div class="col-form-label col-lg-6 col-md-6 col-sm-12 text-right">
                                                    <span>{{ $receiver->getPaymentDataDTO()->getCardNumber() }}</span>
                                                </div>
                                            </div>
                                        @endif
                                        @if (null !== $receiver->getPaymentDataDTO()->getPhoneNumber())
                                            <hr/>
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-6 col-md-6 col-sm-12 text-left">{{ __('pages.p2p-phone-number') }}</label>
                                                <div class="col-form-label col-lg-6 col-md-6 col-sm-12 text-right">
                                                    <span>{{ $receiver->getPaymentDataDTO()->getPhoneNumber() }}</span>
                                                </div>
                                            </div>
                                        @endif
                                        @if (null !== $receiver->getPaymentDataDTO()->getComment())
                                            <hr/>
                                            <div class="form-group row">
                                                <div class="col-form-label col-lg-12 col-md-12 col-sm-12 text-center">
                                                    <span>{{ $receiver->getPaymentDataDTO()->getComment() }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </span>
                                </span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#p2pSubmitModal">
                            {{ __('pages.p2p-submit') }}
                        </button>
                        <button type="submit" class="btn btn-secondary">{{ __('pages.p2p-cancel') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="p2pSubmitModal" tabindex="-1" role="dialog" aria-labelledby="p2pSubmitModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('pages.p2p-submit-confirmation-title') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('balance.createP2PTransaction') }}" method="POST" id="submitP2PTransactionForm">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="amount" value="{{ $amount }}" />
                        <input type="hidden" name="receiver_id" value="" id="receiver_id" />
                        <div class="row" id="p2p_fio_row">
                            <div class="col-md-4 col-sm-12 text-right">
                                <label for="" class="form-label">{{ __('pages.p2p-receiver-fio') }}</label>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <span id="p2p_fio"></span>
                            </div>
                        </div>
                        <div class="row" id="p2p_card_row">
                            <div class="col-md-4 col-sm-12 text-right">
                                <label for="" class="form-label">{{ __('pages.p2p-card-number') }}</label>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <span id="p2p_card"></span>
                            </div>
                        </div>
                        <div class="row" id="p2p_phone_row">
                            <div class="col-md-4 col-sm-12 text-right">
                                <label for="" class="form-label">{{ __('pages.p2p-phone-number') }}</label>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <span id="p2p_phone"></span>
                            </div>
                        </div>
                        <div class="row" id="p2p_comment_row">
                            <div class="col-md-4 col-sm-12 text-right">
                                <label for="" class="form-label">{{ __('pages.p2p-comment') }}</label>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <span id="p2p_comment"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('pages.cancel') }}</button>
                        <button type="button" class="btn btn-primary" onclick="$('#submitP2PTransactionForm').submit()">{{ __('pages.p2p-submit-confirmation-button') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

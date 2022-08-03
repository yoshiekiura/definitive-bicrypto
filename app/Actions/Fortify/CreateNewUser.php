<?php

namespace App\Actions\Fortify;

use App\Models\AdminNotification;
use App\Models\Extension;
use App\Models\GeneralSetting;
use App\Models\MLM;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'firstname' => ['required', 'string', 'max:60'],
            'lastname' => ['required', 'string', 'max:60'],
            'username' => ['required','string', 'alpha_num', 'unique:users', 'min:6'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        $gnl = GeneralSetting::first();
        $referBy = session()->get('reference');
        if ($referBy) {
            $referUser = User::where('username', $referBy)->first();
        } else {
            $referUser = null;
        }

        if(Extension::where('id',3)->first()->status == 1){
            $newmlm = new MLM();
            $newmlm->username = $input['username'];
            $newmlm->save();
            if($referUser != null){
                $mlm = getH($referBy);
                if($mlm->L == null){
                    $mlm->L = $input['username'];$mlm->save();
                } elseif ($mlm->R == null){
                    $mlm->R = $input['username'];$mlm->save();
                }
                elseif($mlm->L != null){ $mlmL = getH($mlm->L);
                    if ($mlmL->L == null){
                        $mlmL->L = $input['username'];$mlmL->save();
                    } elseif ($mlmL->R == null){
                        $mlmL->R = $input['username'];$mlmL->save();
                    }
                    elseif($mlm->R != null){ $mlmR = getH($mlm->R);
                        if ($mlmR->L == null){
                            $mlmR->L = $input['username'];$mlmR->save();
                        } elseif ($mlmR->R == null){
                            $mlmR->R = $input['username'];$mlmR->save();
                        }
                        elseif($mlmL->L != null){ $mlmLL = getH($mlmL->L);
                            if ($mlmLL->L == null){
                                $mlmLL->L = $input['username'];$mlmLL->save();
                            } elseif ($mlmLL->R == null){
                                $mlmLL->R = $input['username'];$mlmLL->save();
                            }
                            elseif($mlmL->R != null){ $mlmLR = getH($mlmL->R);
                                if ($mlmLR->L == null){
                                    $mlmLR->L = $input['username'];$mlmLR->save();
                                } elseif ($mlmLR->R == null){
                                    $mlmLR->R = $input['username'];$mlmLR->save();
                                }
                                elseif($mlmR->L != null){ $mlmRL = getH($mlmR->L);
                                    if ($mlmRL->L == null){
                                        $mlmRL->L = $input['username'];$mlmRL->save();
                                    } elseif ($mlmRL->R == null){
                                        $mlmRL->R = $input['username'];$mlmRL->save();
                                    }
                                    elseif($mlmR->R != null){ $mlmRR = getH($mlmR->R);
                                        if ($mlmRR->L == null){
                                            $mlmRR->L = $input['username'];$mlmRR->save();
                                        } elseif ($mlmRR->R == null){
                                            $mlmRR->R = $input['username'];$mlmRR->save();
                                        }
                                        elseif($mlmLL->L != null){ $mlmLLL = getH($mlmLL->L);
                                            if ($mlmLLL->L == null){
                                                $mlmLLL->L = $input['username'];$mlmLLL->save();
                                            } elseif ($mlmLLL->R == null){
                                                $mlmLLL->R = $input['username'];$mlmLLL->save();
                                            }
                                            elseif($mlmLL->R != null){ $mlmLLR = getH($mlmLL->R);
                                                if ($mlmLLR->L == null){
                                                    $mlmLLR->L = $input['username'];$mlmLLR->save();
                                                } elseif ($mlmLLR->R == null){
                                                    $mlmLLR->R = $input['username'];$mlmLLR->save();
                                                }
                                                elseif($mlmLR->L != null){ $mlmLRL = getH($mlmLR->L);
                                                    if ($mlmLRL->L == null){
                                                        $mlmLRL->L = $input['username'];$mlmLRL->save();
                                                    } elseif ($mlmLRL->R == null){
                                                        $mlmLRL->R = $input['username'];$mlmLRL->save();
                                                    }
                                                    elseif($mlmLR->R != null){ $mlmLRR = getH($mlmLR->R);
                                                        if ($mlmLRR->L == null){
                                                            $mlmLRR->L = $input['username'];$mlmLRR->save();
                                                        } elseif ($mlmLRR->R == null){
                                                            $mlmLRR->R = $input['username'];$mlmLRR->save();
                                                        }
                                                        elseif($mlmRL->L != null){ $mlmRLL = getH($mlmRL->L);
                                                            if ($mlmRLL->L == null){
                                                                $mlmRLL->L = $input['username'];$mlmRLL->save();
                                                            } elseif ($mlmRLL->R == null){
                                                                $mlmRLL->R = $input['username'];$mlmRLL->save();
                                                            }
                                                            elseif($mlmRL->R != null){ $mlmRLR = getH($mlmRL->R);
                                                                if ($mlmRLR->L == null){
                                                                    $mlmRLR->L = $input['username'];$mlmRLR->save();
                                                                } elseif ($mlmRLR->R == null){
                                                                    $mlmRLR->R = $input['username'];$mlmRLR->save();
                                                                }
                                                                elseif($mlmRR->L != null){ $mlmRRL = getH($mlmRR->L);
                                                                    if ($mlmRRL->L == null){
                                                                        $mlmRRL->L = $input['username'];$mlmRRL->save();
                                                                    } elseif ($mlmRRL->R == null){
                                                                        $mlmRRL->R = $input['username'];$mlmRRL->save();
                                                                    }
                                                                    elseif($mlmRR->R != null){ $mlmRRR = getH($mlmRR->R);
                                                                        if ($mlmRRR->L == null){
                                                                            $mlmRRR->L = $input['username'];$mlmRRR->save();
                                                                        } elseif ($mlmRRR->R == null){
                                                                            $mlmRRR->R = $input['username'];$mlmRRR->save();
                                                                        }
                                                                        elseif($mlmLLL->L != null){  $mlmLLLL = getH($mlmLLL->L);
                                                                            if ($mlmLLLL->L == null){
                                                                                $mlmLLLL->L = $input['username'];$mlmLLLL->save();
                                                                            } elseif ($mlmLLLL->R == null){
                                                                                $mlmLLLL->R = $input['username'];$mlmLLLL->save();
                                                                            }
                                                                            elseif($mlmLLL->R != null){  $mlmLLLR = getH($mlmLLL->R);
                                                                                if ($mlmLLLR->L == null){
                                                                                    $mlmLLLR->L = $input['username'];$mlmLLLR->save();
                                                                                } elseif ($mlmLLLR->R == null){
                                                                                    $mlmLLLR->R = $input['username'];$mlmLLLR->save();
                                                                                }
                                                                                elseif($mlmLLR->L != null){  $mlmLLRL = getH($mlmLLR->L);
                                                                                    if ($mlmLLRL->L == null){
                                                                                        $mlmLLRL->L = $input['username'];$mlmLLRL->save();
                                                                                    } elseif ($mlmLLRL->R == null){
                                                                                        $mlmLLRL->R = $input['username'];$mlmLLRL->save();
                                                                                    }
                                                                                    elseif($mlmLLR->R != null){ $mlmLLRR = getH($mlmLLR->R);
                                                                                        if ($mlmLLRR->L == null){
                                                                                            $mlmLLRR->L = $input['username'];$mlmLLRR->save();
                                                                                        } elseif ($mlmLLRR->R == null){
                                                                                            $mlmLLRR->R = $input['username'];$mlmLLRR->save();
                                                                                        }
                                                                                        elseif($mlmLRL->L != null){ $mlmLRLL = getH($mlmLRL->L);
                                                                                            if ($mlmLRLL->L == null){
                                                                                                $mlmLRLL->L = $input['username'];$mlmLRLL->save();
                                                                                            } elseif ($mlmLRLL->R == null){
                                                                                                $mlmLRLL->R = $input['username'];$mlmLRLL->save();
                                                                                            }
                                                                                            elseif($mlmLRL->R != null){ $mlmLRLR = getH($mlmLRL->R);
                                                                                                if ($mlmLRLR->L == null){
                                                                                                    $mlmLRLR->L = $input['username'];$mlmLRLR->save();
                                                                                                } elseif ($mlmLRLR->R == null){
                                                                                                    $mlmLRLR->R = $input['username'];$mlmLRLR->save();
                                                                                                }
                                                                                                elseif($mlmLRR->L != null){ $mlmLRRL = getH($mlmLRR->L);
                                                                                                    if ($mlmLRRL->L == null){
                                                                                                        $mlmLRRL->L = $input['username'];$mlmLRRL->save();
                                                                                                    } elseif ($mlmLRRL->R == null){
                                                                                                        $mlmLRRL->R = $input['username'];$mlmLRRL->save();
                                                                                                    }
                                                                                                    elseif($mlmLRR->R != null){ $mlmLRRR = getH($mlmLRR->R);
                                                                                                        if ($mlmLRRR->L == null){
                                                                                                            $mlmLRRR->L = $input['username'];$mlmLRRR->save();
                                                                                                        } elseif ($mlmLRRR->R == null){
                                                                                                            $mlmLRRR->R = $input['username'];$mlmLRRR->save();
                                                                                                        }
                                                                                                        elseif($mlmRLL->L != null){ $mlmRLLL = getH($mlmRLL->L);
                                                                                                            if ($mlmRLLL->L == null){
                                                                                                                $mlmRLLL->L = $input['username'];$mlmRLLL->save();
                                                                                                            } elseif ($mlmRLLL->R == null){
                                                                                                                $mlmRLLL->R = $input['username'];$mlmRLLL->save();
                                                                                                            }
                                                                                                            elseif($mlmRLL->R != null){ $mlmRLLR = getH($mlmRLL->R);
                                                                                                                if ($mlmRLLR->L == null){
                                                                                                                    $mlmRLLR->L = $input['username'];$mlmRLLR->save();
                                                                                                                } elseif ($mlmRLLR->R == null){
                                                                                                                    $mlmRLLR->R = $input['username'];$mlmRLLR->save();
                                                                                                                }
                                                                                                                elseif($mlmRLR->L != null){ $mlmRLRL = getH($mlmRLR->L);
                                                                                                                    if ($mlmRLRL->L == null){
                                                                                                                        $mlmRLRL->L = $input['username'];$mlmRLRL->save();
                                                                                                                    } elseif ($mlmRLRL->R == null){
                                                                                                                        $mlmRLRL->R = $input['username'];$mlmRLRL->save();
                                                                                                                    }
                                                                                                                    elseif($mlmRLR->R != null){ $mlmRLRR = getH($mlmRLR->R);
                                                                                                                        if ($mlmRLRR->L == null){
                                                                                                                            $mlmRLRR->L = $input['username'];$mlmRLRR->save();
                                                                                                                        } elseif ($mlmRLRR->R == null){
                                                                                                                            $mlmRLRR->R = $input['username'];$mlmRLRR->save();
                                                                                                                        }
                                                                                                                        elseif($mlmRRL->L != null){ $mlmRRLL = getH($mlmRRL->L);
                                                                                                                            if ($mlmRRLL->L == null){
                                                                                                                                $mlmRRLL->L = $input['username'];$mlmRRLL->save();
                                                                                                                            } elseif ($mlmRRLL->R == null){
                                                                                                                                $mlmRRLL->R = $input['username'];$mlmRRLL->save();
                                                                                                                            }
                                                                                                                            elseif($mlmRRL->R != null){ $mlmRRLR = getH($mlmRRL->R);
                                                                                                                                if ($mlmRRLR->L == null){
                                                                                                                                    $mlmRRLR->L = $input['username'];$mlmRRLR->save();
                                                                                                                                } elseif ($mlmRRLR->R == null){
                                                                                                                                    $mlmRRLR->R = $input['username'];$mlmRRLR->save();
                                                                                                                                }
                                                                                                                                elseif($mlmRRR->L != null){ $mlmRRRL = getH($mlmRRR->L);
                                                                                                                                    if ($mlmRRRL->L == null){
                                                                                                                                        $mlmRRRL->L = $input['username'];$mlmRRRL->save();
                                                                                                                                    } elseif ($mlmRRRL->R == null){
                                                                                                                                        $mlmRRRL->R = $input['username'];$mlmRRRL->save();
                                                                                                                                    }
                                                                                                                                    elseif($mlmRRR->L != null){ $mlmRRRR = getH($mlmRRR->R);
                                                                                                                                        if ($mlmRRRR->L == null){
                                                                                                                                            $mlmRRRR->L = $input['username'];$mlmRRRR->save();
                                                                                                                                        } elseif ($mlmRRRR->R == null){
                                                                                                                                            $mlmRRRR->R = $input['username'];$mlmRRRR->save();
                                                                                                                                        }
                                                                                                                                    }
                                                                                                                                }
                                                                                                                            }
                                                                                                                        }
                                                                                                                    }
                                                                                                                }
                                                                                                            }
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $user = new User();

        return User::create([
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'name' => $input['firstname'].' '.$input['lastname'],
            'firstname' => $input['firstname'],
            'lastname' => $input['lastname'],
            'username' => $input['username'],
            'ref_by' => $referUser ? $referUser->id : null,
            'status' => '1',
            'role_id' => '2',
        ]);

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'New member registered';
        $adminNotification->click_url = route('admin.users.detail',$user->id);
        $adminNotification->save();
    }
}

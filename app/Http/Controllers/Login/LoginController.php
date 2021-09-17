<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.login');
    }

    public function validationlogin(Request $request)
    {
        $ldap_password = $request->password;
        $username = "onekalbe\\";
        $username2 = $request->username;
        $username3 = $username . $username2;

        $parameter = [$username2, $ldap_password];
        $userexists = DB::select('EXEC sp_m_user_selectexists ?, ?', $parameter);

        if($userexists[0]->Result == '1'){

            $parameter2 = [$username2, $ldap_password];
            $datauser = DB::select('EXEC sp_m_user_selectone ?, ?', $parameter2);

            session(['UserID' => $datauser[0]->user_id]);
            session(['FullName' => $datauser[0]->full_name]);
            session(['Department' => $datauser[0]->department]);
            session(['Title' => $datauser[0]->title]);
            session(['Mail' => $datauser[0]->mail]);
            session(['Company' => $datauser[0]->company]);
            session(['Manager' => $datauser[0]->manager_name]);
            session(['Nik' => $datauser[0]->nik]);
            session(['SubDepartment' => $datauser[0]->subdepartment]);

            $parameter3 = [$datauser[0]->nik, $request->ip()];

            DB::insert('EXEC sp_t_log_akses_insert ?, ?', $parameter3);

            return redirect('/dashboard');
        }else{
            //LDAP Bind paramters, need to be a normal AD User account.
            $ldap_username = $username3;
            $ldap_connection = ldap_connect("onekalbe.dom");

            // We have to set this option for the version of Active Directory we are using.
            ldap_set_option($ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
            ldap_set_option($ldap_connection, LDAP_OPT_REFERRALS, 0); // We need this for doing an LDAP search.

            try
            {
                if (TRUE === ldap_bind($ldap_connection, $ldap_username, $ldap_password))
                {
                    $parameter2 = [$username2];
                    $userexists = DB::select('EXEC sp_m_user_selectexistsldap ?', $parameter2);

                    if($userexists[0]->Result == '1'){

                        $parameter3 = [$username2, $ldap_password];
                        $datauser = DB::select('EXEC sp_m_user_selectone ?, ?', $parameter3);

                        session(['UserID' => $datauser[0]->user_id]);
                        session(['FullName' => $datauser[0]->full_name]);
                        session(['Department' => $datauser[0]->department]);
                        session(['Title' => $datauser[0]->title]);
                        session(['Mail' => $datauser[0]->mail]);
                        session(['Company' => $datauser[0]->company]);
                        session(['Manager' => $datauser[0]->manager_name]);
                        session(['Nik' => $datauser[0]->nik]);
                        session(['SubDepartment' => $datauser[0]->subdepartment]);

                        $parameter4 = [$datauser[0]->nik, $request->ip()];

                        DB::insert('EXEC sp_t_log_akses_insert ?, ?', $parameter4);

                        return redirect('/dashboard');
                    }else{
                        //Your domains DN to query
                        $ldap_base_dn = 'DC=onekalbe,DC=dom';

                        $search_filter = '(&(objectClass=user)(sAMAccountName=' . $username2 . '))';

                        //Connect to LDAP
                        $result = ldap_search($ldap_connection, $ldap_base_dn, $search_filter);

                        if (FALSE !== $result)
                        {
                            $entries = ldap_get_entries($ldap_connection, $result);

                            //For each account returned by the search
                            for ($x = 0; $x < $entries['count']; $x++)
                            {
                                //User ID
                                $LDAP_UserID = "";

                                if (!empty($entries[$x]['samaccountname'][0])) {
                                    $LDAP_UserID = $entries[$x]['samaccountname'][0];
                                    if ($LDAP_UserID == "NULL") {
                                        $LDAP_UserID = "";
                                    }
                                }

                                session(['UserID' => $LDAP_UserID]);

                                //Full Name
                                $LDAP_FullName = "";

                                if (!empty($entries[$x]['cn'][0])) {
                                    $LDAP_FullName = $entries[$x]['cn'][0];
                                    if ($LDAP_FullName == "NULL") {
                                        $LDAP_FullName = "";
                                    }
                                }

                                session(['FullName' => $LDAP_FullName]);

                                //Department
                                $LDAP_Department = "";

                                if (!empty($entries[$x]['department'][0])) {
                                    $LDAP_Department = $entries[$x]['department'][0];
                                    if ($LDAP_Department == "NULL") {
                                        $LDAP_Department = "";
                                    }
                                }

                                session(['Department' => $LDAP_Department]);

                                //Title
                                $LDAP_Title = "";

                                if (!empty($entries[$x]['title'][0])) {
                                    $LDAP_Title = $entries[$x]['title'][0];
                                    if ($LDAP_Title == "NULL") {
                                        $LDAP_Title = "";
                                    }
                                }

                                session(['Title' => $LDAP_Title]);

                                //Mail
                                $LDAP_Mail = "";

                                if (!empty($entries[$x]['mail'][0])) {
                                    $LDAP_Mail = $entries[$x]['mail'][0];
                                    if ($LDAP_Mail == "NULL") {
                                        $LDAP_Mail = "";
                                    }
                                }

                                session(['Mail' => $LDAP_Mail]);

                                //Company
                                $LDAP_Company = "";

                                if (!empty($entries[$x]['company'][0])) {
                                    $LDAP_Company = $entries[$x]['company'][0];
                                    if ($LDAP_Company == "NULL") {
                                        $LDAP_Company = "";
                                    }
                                }

                                session(['Company' => $LDAP_Company]);

                                //Manager Name
                                $LDAP_Manager = "";

                                if (!empty(str_replace('CN=', '', strstr($entries[0]["manager"][0], ',', true)))) {
                                    $LDAP_Manager = str_replace('CN=', '', strstr($entries[0]["manager"][0], ',', true));
                                    if ($LDAP_Manager == "NULL") {
                                        $LDAP_Manager = "";
                                    }
                                }

                                session(['Manager' => $LDAP_Manager]);

                                //Nik
                                $LDAP_Nik = "";

                                if (!empty($entries[$x]['employeenumber'][0])) {
                                    $LDAP_Nik = $entries[$x]['employeenumber'][0];
                                    if ($LDAP_Nik == "NULL") {
                                        $LDAP_Nik = "";
                                    }
                                }

                                session(['Nik' => $LDAP_Nik]);

                                $parameter5 = [$LDAP_Nik, $LDAP_UserID, $LDAP_FullName, $LDAP_Department, $LDAP_Title, $LDAP_Mail, $LDAP_Company, $LDAP_Manager];

                                DB::insert('EXEC sp_m_user_insertupdate_ldap ?, ?, ?, ?, ?, ?, ?, ?', $parameter5);

                                $parameter6 = [$LDAP_Nik, $request->ip()];

                                DB::insert('EXEC sp_t_log_akses_insert ?, ?', $parameter6);

                                // $parameter4 = [$LDAP_Nik];

                                // $subdept =  DB::select('EXEC sp_subdept_select ?', $parameter4);

                                session(['SubDepartment' => $LDAP_Department]);
                            }

                        }

                        return redirect('/dashboard');
                    }
                }
                else{
                    Alert::error('Oops...', 'Incorrect Username Or Password');
                    return back();
                }
            }
            catch (Exception $e)
            {
                Alert::error('Oops...', 'Incorrect Username Or Password');
                return back();
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

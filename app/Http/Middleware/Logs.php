<?php

namespace App\Http\Middleware;
use App\Eventtype;
use App\Module;
use App\Scan;
use Closure;
use App\Log;
use Illuminate\Support\Facades\Route;


class Logs
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

       $response = $next($request);

        $name = $request->route()->getName();

        switch ($name){

            // Scan Profiles
            case 'perfilesescaneo.index':
                $log=new Log();
                $log->name='Scan Profiles';
                $log->description='Entry to the scan profile by the user:  '.$request->user()->name;
                $log->user_id=$request->user()->id;
                $log->route=Route::current()->uri;
                $log->ip=$request->ip();
                $log->session_id=$request->session()->getId();
                $log->duration=0;
                $log->save();
                break;

            case 'perfilesescaneo.store':
                $log=new Log();
                $log->name='Scan Profiles';
                $log->description='Scan profile created by user:  '.$request->user()->name;
                $log->user_id=$request->user()->id;
                $log->route=Route::current()->uri;
                $log->ip=$request->ip();
                $log->session_id=$request->session()->getId();
                $log->duration=0;
                $log->save();
                break;

            // Api Manager
            case 'configuraciones.index':
                $log=new Log();
                $log->name='Api Manager';
                $log->description='Login to the API manager by the user:  '.$request->user()->name;
                $log->user_id=$request->user()->id;
                $log->route=Route::current()->uri;
                $log->ip=$request->ip();
                $log->session_id=$request->session()->getId();
                $log->duration=0;
                $log->save();
                break;

            case 'configuraciones.store':
                $log=new Log();
                $log->name='Api Manager';
                $log->description='API created by user:  '.$request->user()->name;
                $log->user_id=$request->user()->id;
                $log->route=Route::current()->uri;
                $log->ip=$request->ip();
                $log->session_id=$request->session()->getId();
                $log->duration=0;
                $log->save();
                break;

            case 'configuraciones.update':
                $log=new Log();
                $log->name='Api Manager';
                $log->description='User-Enabled Scanning API User:  '.$request->user()->name;
                $log->user_id=$request->user()->id;
                $log->route=Route::current()->uri;
                $log->ip=$request->ip();
                $log->session_id=$request->session()->getId();
                $log->duration=0;
                $log->save();
                break;
            // User Manager
            case 'users.index':
                $log=new Log();
                $log->name='User Manager';
                $log->description='Entry to User Manager by User:  '.$request->user()->name;
                $log->user_id=$request->user()->id;
                $log->route=Route::current()->uri;
                $log->ip=$request->ip();
                $log->session_id=$request->session()->getId();
                $log->duration=0;
                $log->save();
                break;

            case 'users.store':
                $log=new Log();
                $log->name='User Manager';
                $log->description='System user created by User:  '.$request->user()->name;
                $log->user_id=$request->user()->id;
                $log->route=Route::current()->uri;
                $log->ip=$request->ip();
                $log->session_id=$request->session()->getId();
                $log->duration=0;
                $log->save();
                break;

            case 'users.destroy':
                $log=new Log();
                $log->name='User Manager';
                $log->description='System user removed by User:  '.$request->user()->name;
                $log->user_id=$request->user()->id;
                $log->route=Route::current()->uri;
                $log->ip=$request->ip();
                $log->session_id=$request->session()->getId();
                $log->duration=0;
                $log->save();
                break;
            // Scan Reports
            case 'Frontend.SummaryGeneral':
                $scan=Scan::where('id','=',$request->scan_id)->first();
                $name_scan=$scan->name;
                $name_modulo=$this->modulo($request->category_id);
                $log=new Log();
                $log->name='Scan Reports';
                $log->description='Query Scan Report ('.$name_scan.' - Bar graph by '.$name_modulo.') by the user '.$request->user()->name;
                $log->user_id=$request->user()->id;
                $log->route=Route::current()->uri;
                $log->ip=$request->ip();
                $log->session_id=$request->session()->getId();
                $log->duration=0;
                $log->save();
                break;

            case 'Frontend.SummaryTotal':
                $scan=Scan::where('id','=',$request->scan_id)->first();
                $name_scan=$scan->name;
                $name_modulo=$this->modulo($request->category_id);
                $log=new Log();
                $log->name='Scan Reports';
                $log->description='See Report Scan ('.$name_scan.' - Pie chart by '.$name_modulo.') by the user '.$request->user()->name;
                $log->user_id=$request->user()->id;
                $log->route=Route::current()->uri;
                $log->ip=$request->ip();
                $log->session_id=$request->session()->getId();
                $log->duration=0;
                $log->save();
                break;

            case 'Frontend.SummaryTable':
                $scan=Scan::where('id','=',$request->scan_id)->first();
                $name_scan=$scan->name;
                $name_modulo=$this->modulo($request->category_id);
                $log=new Log();
                $log->name='Scan Reports';
                $log->description='See Report Scan ('.$name_scan.' - Summary details by '.$name_modulo.') by the user '.$request->user()->name;
                $log->user_id=$request->user()->id;
                $log->route=Route::current()->uri;
                $log->ip=$request->ip();
                $log->session_id=$request->session()->getId();
                $log->duration=0;
                $log->save();
                break;

            case 'Resuldata.module':
                $scan=Scan::where('id','=',$request->scan_id)->first();
                $name_scan=$scan->name;
                $modulo=Module::where('id','=',$request->module_id)->first();
                $name_modulo=$modulo->name;
                $log=new Log();
                $log->name='Scan Reports Details Modulos';
                $log->description='See details Scan ('.$name_scan.' - '.$name_modulo.') performed by the user '.$request->user()->name;
                $log->user_id=$request->user()->id;
                $log->route=Route::current()->uri;
                $log->ip=$request->ip();
                $log->session_id=$request->session()->getId();
                $log->duration=0;
                $log->save();
                break;

            case 'Resultdata.eventtype':
                $scan=Scan::where('id','=',$request->scan_id)->first();
                $name_scan=$scan->name;
                $type=Eventtype::where('id','=',$request->eventtype)->first();
                $name_type=$type->name;
                $log=new Log();
                $log->name='Scan Reports Details EventType';
                $log->description='See details Scan ('.$name_scan.' - '.$name_type.') performed by the user '.$request->user()->name;
                $log->user_id=$request->user()->id;
                $log->route=Route::current()->uri;
                $log->ip=$request->ip();
                $log->session_id=$request->session()->getId();
                $log->duration=0;
                $log->save();
                break;

        }


        return $response;


    }

    public function modulo ($modulo){
        switch ($modulo){
            case 1:
                return $name_modulo='Module';
                break;
            case 2:
                return $name_modulo='Type';
                break;
            case 3:
                return $name_modulo='Category';
                break;
            case 4:
                return $name_modulo='Source';
                break;
            case 5:
                return $name_modulo='Family';
                break;
        }

    }


}

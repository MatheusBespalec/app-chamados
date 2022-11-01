<?php

namespace App\Http\Controllers;

use App\Conections\Aws\Modules\LambdaFunction;
use App\Http\Requests\LambdaUpdateRequest;
use App\Http\Requests\WebhookUpdateRequest;
use App\Models\BancoDigital;
use App\Models\Customer;
use App\Models\Log;
use App\Models\Project;
use Exception;
use Illuminate\Http\Request;

class BancoDigitalController extends Controller
{
    public function getProject(): ?Project
    {
        return Project::query()->where('private_route', 'banco-digital')->first();
    }

    public function index()
    {
        $project = $this->getProject();
        $project->load('bancosDigitais');
        return inertia('Project/BancoDigital/Index', [
            'project' => $project,
            'customers' => $project->customers()->paginate(10)
        ]);
    }

    public function show(Customer $customer)
    {
        $project = $this->getProject();
        $bancoDigital = BancoDigital::query()->where('customer_id', $customer->id)->first();
        if (is_null($bancoDigital)) {
            $bancoDigital = BancoDigital::create([
                'project_id' => $project->id,
                'customer_id' => $customer->id,
            ]);
        }

        $logs = Log::query()->where('project_id', $project->id)->where('customer_id', $customer->id)->limit(10)->get();
        try {
            if (!empty($customer->bancoDigital->env_lambda)) {
                $lambdaFuntion = new LambdaFunction($customer->bancoDigital->env_lambda);
            }
        } catch (Exception) {}
        return inertia('Project/BancoDigital/Show', [
            'project' => $project,
            'customer' => $customer,
            'bancoDigital' => $bancoDigital,
            'logs' => $logs,
            'debugIsEnable' => isset($lambdaFuntion) ? $lambdaFuntion->debugIsEnable() : false,
            'vanIsEnable' => isset($lambdaFuntion) ? $lambdaFuntion->vanIsEnable() : false,
            'ipDebug' => isset($lambdaFuntion) ? $lambdaFuntion->getIpDebug() : '',
        ]);
    }

    public function enableIpDebug(Customer $customer, Request $request)
    {
        $lambdaFuntion = new LambdaFunction($customer->bancoDigital->env_lambda);
        $lambdaFuntion->enableIpDebug($request->ip());
        return back();
    }

    public function enableDebug(Customer $customer)
    {
        $lambdaFuntion = new LambdaFunction($customer->bancoDigital->env_lambda);
        $lambdaFuntion->enableDebug();
        return back()->withSuccess('Debug Habilitado');
    }

    public function disableDebug(Customer $customer)
    {
        $lambdaFuntion = new LambdaFunction($customer->bancoDigital->env_lambda);
        $lambdaFuntion->disableDebug();
        return back()->withSuccess('Debug Desabilidato');
    }

    public function disableVan(Customer $customer)
    {
        $lambdaFuntion = new LambdaFunction($customer->bancoDigital->env_lambda);
        $lambdaFuntion->disableVan();
        return back()->withSuccess('Van Desabilitada');
    }

    public function enableIpDebugs(Request $request)
    {
        foreach (BancoDigital::all() as $bank) {
            $lambdaFuntion = new LambdaFunction($bank->env_lambda);
            $lambdaFuntion->enableIpDebug($request->ip());
        }
        return back()->withSuccess('Seu ip foi liberado em todos os bancos!');
    }

    public function disableVans()
    {
        foreach (BancoDigital::all() as $bank) {
            $lambdaFuntion = new LambdaFunction($bank->env_lambda);
            $lambdaFuntion->disableVan();
        }
        return back()->withSuccess('Todas as Vans foram desabilitadas!');
    }

    public function disableDebugs()
    {
        foreach (BancoDigital::all() as $bank) {
            $lambdaFuntion = new LambdaFunction($bank->env_lambda);
            $lambdaFuntion->disableDebug();
        }
        return back()->withSuccess('Todas os debugs foram desabilitados!');
    }

    public function updateWebhook(Customer $customer, WebhookUpdateRequest $request)
    {
        if ($customer->bancoDigital->update(['webhook' => $request->webhook])) {
            return back()->withSuccess('A Url do webhook foi alterada com sucesso!');
        }

        return back()->withError('Houve um erro ao alterar o webhook!');
    }

    public function updateLambda(Customer $customer, LambdaUpdateRequest $request)
    {
        if ($customer->bancoDigital->update(['env_lambda' => $request->lambda])) {
            return back()->withSuccess('Função Lambda alterada com sucesso!');
        }

        return back()->withError('Houve um erro ao alterar a função lambda!');
    }
}

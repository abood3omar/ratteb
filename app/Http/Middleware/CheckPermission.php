<?php

namespace App\Http\Middleware;

use App\Models\Action;
use App\Models\Entity;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $entity, $action)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        $entityModel = Entity::where('EntityName', $entity)->first();
        $actionModel = Action::where('ActionName', $action)->first();

        if (!$entityModel || !$actionModel) {
            abort(403, 'Entity or Action does not exist.');
        }

        $entityId = $entityModel->EntityID;
        $actionId = $actionModel->ActionID;
        $entityHasAction = $entityModel->actions()->where('entity_actions.ActionID', $actionId)->exists();

        if (!$entityHasAction) {
            abort(403, 'This action is not allowed for this entity.');
        }

        if (!Auth::user()->hasPermission($entityId, $actionId)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
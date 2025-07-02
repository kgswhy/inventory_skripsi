<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait HandlesErrors
{
    /**
     * Handle and log errors with consistent response format
     * 
     * @param \Exception $exception
     * @param string $operation
     * @param Request|null $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    protected function handleError(\Exception $exception, string $operation = 'operation', Request $request = null)
    {
        // Log the error with context
        Log::error("Error in {$operation}: " . $exception->getMessage(), [
            'exception' => get_class($exception),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString(),
            'request_data' => $request ? $request->only(['name', 'email', 'username', 'phone']) : null,
            'user_id' => auth()->id(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // Determine error response based on exception type
        return $this->buildErrorResponse($exception, $operation, $request);
    }

    /**
     * Build appropriate error response based on exception type
     * 
     * @param \Exception $exception
     * @param string $operation
     * @param Request|null $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    protected function buildErrorResponse(\Exception $exception, string $operation, Request $request = null)
    {
        $isAjax = $request ? $request->ajax() || $request->wantsJson() : false;

        // Handle specific exception types
        if ($exception instanceof ValidationException) {
            return $this->handleValidationError($exception, $isAjax);
        }

        if ($exception instanceof ModelNotFoundException) {
            return $this->handleNotFoundError($exception, $isAjax);
        }

        if ($exception instanceof AuthorizationException) {
            return $this->handleAuthorizationError($exception, $isAjax);
        }

        if ($exception instanceof HttpException) {
            return $this->handleHttpError($exception, $isAjax);
        }

        // Handle database errors
        if ($this->isDatabaseError($exception)) {
            return $this->handleDatabaseError($exception, $operation, $isAjax);
        }

        // Handle general errors
        return $this->handleGeneralError($exception, $operation, $isAjax);
    }

    /**
     * Handle validation errors
     */
    protected function handleValidationError(ValidationException $exception, bool $isAjax = false)
    {
        if ($isAjax) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $exception->errors()
            ], 422);
        }

        return redirect()->back()
            ->withErrors($exception->errors())
            ->withInput()
            ->with('error', 'Terdapat kesalahan pada formulir. Silakan periksa kembali data yang Anda masukkan.');
    }

    /**
     * Handle model not found errors
     */
    protected function handleNotFoundError(ModelNotFoundException $exception, bool $isAjax = false)
    {
        $modelName = $this->getReadableModelName($exception);

        if ($isAjax) {
            return response()->json([
                'success' => false,
                'message' => "{$modelName} tidak ditemukan"
            ], 404);
        }

        return redirect()->back()
            ->with('error', "{$modelName} yang Anda cari tidak ditemukan.");
    }

    /**
     * Handle authorization errors
     */
    protected function handleAuthorizationError(AuthorizationException $exception, bool $isAjax = false)
    {
        if ($isAjax) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki izin untuk melakukan operasi ini'
            ], 403);
        }

        return redirect()->back()
            ->with('error', 'Anda tidak memiliki izin untuk melakukan operasi ini.');
    }

    /**
     * Handle HTTP errors
     */
    protected function handleHttpError(HttpException $exception, bool $isAjax = false)
    {
        $statusCode = $exception->getStatusCode();
        $message = $this->getHttpErrorMessage($statusCode);

        if ($isAjax) {
            return response()->json([
                'success' => false,
                'message' => $message
            ], $statusCode);
        }

        return redirect()->back()->with('error', $message);
    }

    /**
     * Handle database errors
     */
    protected function handleDatabaseError(\Exception $exception, string $operation, bool $isAjax = false)
    {
        $message = $this->getDatabaseErrorMessage($exception, $operation);

        if ($isAjax) {
            return response()->json([
                'success' => false,
                'message' => $message
            ], 500);
        }

        return redirect()->back()
            ->withInput()
            ->with('error', $message);
    }

    /**
     * Handle general errors
     */
    protected function handleGeneralError(\Exception $exception, string $operation, bool $isAjax = false)
    {
        $message = config('app.debug')
            ? $exception->getMessage()
            : "Terjadi kesalahan saat {$operation}. Silakan coba lagi.";

        if ($isAjax) {
            return response()->json([
                'success' => false,
                'message' => $message
            ], 500);
        }

        return redirect()->back()
            ->withInput()
            ->with('error', $message);
    }

    /**
     * Execute operation with error handling
     * 
     * @param callable $operation
     * @param string $operationName
     * @param Request|null $request
     * @return mixed
     */
    protected function executeWithErrorHandling(callable $operation, string $operationName, Request $request = null)
    {
        try {
            return $operation();
        } catch (\Exception $exception) {
            return $this->handleError($exception, $operationName, $request);
        }
    }

    /**
     * Check if exception is database related
     */
    protected function isDatabaseError(\Exception $exception): bool
    {
        return $exception instanceof \Illuminate\Database\QueryException ||
            $exception instanceof \PDOException ||
            str_contains($exception->getMessage(), 'database') ||
            str_contains($exception->getMessage(), 'connection') ||
            str_contains($exception->getMessage(), 'SQLSTATE');
    }

    /**
     * Get readable model name from exception
     */
    protected function getReadableModelName(ModelNotFoundException $exception): string
    {
        $modelClass = $exception->getModel();
        $modelName = class_basename($modelClass);

        $translations = [
            'User' => 'Pengguna',
            'Staff' => 'Staff',
            'Product' => 'Produk',
            'Category' => 'Kategori',
            'PurchaseOrder' => 'Pesanan Pembelian',
        ];

        return $translations[$modelName] ?? $modelName;
    }

    /**
     * Get HTTP error message
     */
    protected function getHttpErrorMessage(int $statusCode): string
    {
        $messages = [
            400 => 'Permintaan tidak valid',
            401 => 'Anda harus login terlebih dahulu',
            403 => 'Akses ditolak',
            404 => 'Halaman tidak ditemukan',
            405 => 'Metode tidak diizinkan',
            429 => 'Terlalu banyak permintaan',
            500 => 'Terjadi kesalahan server',
            502 => 'Server tidak dapat diakses',
            503 => 'Layanan tidak tersedia',
        ];

        return $messages[$statusCode] ?? 'Terjadi kesalahan';
    }

    /**
     * Get database error message
     */
    protected function getDatabaseErrorMessage(\Exception $exception, string $operation): string
    {
        $message = $exception->getMessage();

        // Common database error patterns
        if (str_contains($message, 'Duplicate entry')) {
            return 'Data yang Anda masukkan sudah ada. Silakan gunakan data yang berbeda.';
        }

        if (str_contains($message, 'foreign key constraint')) {
            return 'Data tidak dapat dihapus karena masih digunakan oleh data lain.';
        }

        if (str_contains($message, 'Connection refused') || str_contains($message, 'Connection timed out')) {
            return 'Tidak dapat terhubung ke database. Silakan coba lagi nanti.';
        }

        if (str_contains($message, 'Table') && str_contains($message, "doesn't exist")) {
            return 'Terjadi kesalahan sistem. Silakan hubungi administrator.';
        }

        return "Terjadi kesalahan database saat {$operation}. Silakan coba lagi.";
    }

    /**
     * Success response helper
     */
    protected function successResponse(string $message, $data = null, int $statusCode = 200)
    {
        if (request()->ajax() || request()->wantsJson()) {
            $response = [
                'success' => true,
                'message' => $message
            ];

            if ($data !== null) {
                $response['data'] = $data;
            }

            return response()->json($response, $statusCode);
        }

        $redirect = redirect()->back()->with('success', $message);

        if ($data !== null && is_array($data)) {
            $redirect->with($data);
        }

        return $redirect;
    }

    /**
     * Log operation for audit trail
     */
    protected function logOperation(string $action, string $model, $modelId = null, array $data = [])
    {
        Log::info("User operation: {$action}", [
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name ?? 'Unknown',
            'action' => $action,
            'model' => $model,
            'model_id' => $modelId,
            'data' => $data,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now(),
        ]);
    }
}
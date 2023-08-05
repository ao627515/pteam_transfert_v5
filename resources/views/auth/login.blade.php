<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
    <!-- Section: Design Block -->
    <section class=" text-center text-lg-start">
        <style>
            .rounded-t-5 {
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
            }

            @media (min-width: 992px) {
            .rounded-tr-lg-0 {
            border-top-right-radius: 0;
            }

            .rounded-bl-lg-5 {
            border-bottom-left-radius: 0.5rem;
            }
            }
        </style>
        <div class="card mb-3">
            <div class="row g-0 d-flex align-items-center">
                <div class="col-lg-4 d-none d-lg-flex">
                    <img src="https://mdbootstrap.com/img/new/ecommerce/vertical/004.jpg" alt="Trendy Pants and Shoes" class="w-100 rounded-t-5 rounded-tr-lg-0 rounded-bl-lg-5" />
                </div>
                <div class="col-lg-8">
                    <div class="card-body py-5 px-md-5">

                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            @if ($errors->any)
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger">
                                        <li>{{ $error }}</li>
                                    </div>
                                @endforeach
                            @endif
                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="email" id="form2Example1" class="form-control" name="email"/>
                                <label class="form-label" for="form2Example1">Email address</label>
                            </div>

                            <!-- Password input -->
                            <div class="form-outline mb-4">
                                <input type="password" id="form2Example2" class="form-control" name="password"/>
                                <label class="form-label" for="form2Example2">Password</label>
                            </div>

                            <!-- Submit button -->
                            <button class="btn btn-primary btn-block mb-4 w-100">Sign in</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section: Design Block -->

</body>
</html>

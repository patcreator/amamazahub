import React, { useState } from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import { User, Mail, Lock, Eye, EyeOff, CheckCircle2, ChevronLeft, AtSign } from 'lucide-react';
import { motion } from 'framer-motion';

export default function Signup() {
    const [showPassword, setShowPassword] = useState(false);
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        username: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post('/signup');
    };

    return (
        <div className="min-h-screen bg-black text-white flex flex-col items-center justify-center p-6 relative overflow-hidden">
            <Head title="Sign up" />

            {/* Background elements */}
            <div className="absolute top-[-10%] right-[-10%] w-[40%] h-[40%] bg-primary/20 blur-[120px] rounded-full"></div>
            <div className="absolute bottom-[-10%] left-[-10%] w-[40%] h-[40%] bg-cyan-500/10 blur-[120px] rounded-full"></div>

            <Link href="/" className="absolute top-8 left-8 flex items-center space-x-2 text-gray-400 hover:text-white transition group">
                <ChevronLeft className="group-hover:-translate-x-1 transition-transform" />
                <span className="font-bold">Back to Home</span>
            </Link>

            <motion.div
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                className="w-full max-w-md bg-gray-900/40 backdrop-blur-xl p-10 rounded-3xl border border-white/10 shadow-2xl z-10 my-10"
            >
                <div className="text-center mb-8">
                    <h1 className="text-4xl font-black italic tracking-tighter mb-2">AMAZAMAHUB</h1>
                    <p className="text-gray-400 font-medium">Join the world of amazing videos!</p>
                </div>

                <form onSubmit={submit} className="space-y-4">
                    <div className="space-y-1">
                        <label className="text-xs font-bold text-gray-500 pl-1 uppercase">Full Name</label>
                        <div className="relative">
                            <User className="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500" size={20} />
                            <input
                                type="text"
                                value={data.name}
                                onChange={(e) => setData('name', e.target.value)}
                                className="w-full bg-black/40 border border-white/10 rounded-2xl py-3.5 pl-12 pr-4 focus:ring-2 focus:ring-primary outline-none"
                                placeholder="Enter your full name"
                                required
                            />
                        </div>
                        {errors.name && <p className="text-red-500 text-[10px] mt-1">{errors.name}</p>}
                    </div>

                    <div className="space-y-1">
                        <label className="text-xs font-bold text-gray-500 pl-1 uppercase">Username</label>
                        <div className="relative">
                            <AtSign className="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500" size={20} />
                            <input
                                type="text"
                                value={data.username}
                                onChange={(e) => setData('username', e.target.value)}
                                className="w-full bg-black/40 border border-white/10 rounded-2xl py-3.5 pl-12 pr-4 focus:ring-2 focus:ring-primary outline-none"
                                placeholder="Choose a unique username"
                                required
                            />
                        </div>
                        {errors.username && <p className="text-red-500 text-[10px] mt-1">{errors.username}</p>}
                    </div>

                    <div className="space-y-1">
                        <label className="text-xs font-bold text-gray-500 pl-1 uppercase">Email</label>
                        <div className="relative">
                            <Mail className="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500" size={20} />
                            <input
                                type="email"
                                value={data.email}
                                onChange={(e) => setData('email', e.target.value)}
                                className="w-full bg-black/40 border border-white/10 rounded-2xl py-3.5 pl-12 pr-4 focus:ring-2 focus:ring-primary outline-none"
                                placeholder="Enter your email"
                                required
                            />
                        </div>
                    </div>

                    <div className="space-y-1">
                        <label className="text-xs font-bold text-gray-500 pl-1 uppercase">Password</label>
                        <div className="relative">
                            <Lock className="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500" size={20} />
                            <input
                                type={showPassword ? 'text' : 'password'}
                                value={data.password}
                                onChange={(e) => setData('password', e.target.value)}
                                className="w-full bg-black/40 border border-white/10 rounded-2xl py-3.5 pl-12 pr-12 focus:ring-2 focus:ring-primary outline-none"
                                placeholder="Create a password"
                                required
                            />
                            <button
                                type="button"
                                onClick={() => setShowPassword(!showPassword)}
                                className="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500"
                            >
                                {showPassword ? <EyeOff size={18} /> : <Eye size={18} />}
                            </button>
                        </div>
                    </div>

                    <button
                        type="submit"
                        disabled={processing}
                        className="w-full bg-primary text-black font-black py-4 rounded-2xl shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition disabled:opacity-50 mt-4"
                    >
                        {processing ? 'Creating account...' : 'Create account'}
                    </button>
                </form>

                <div className="mt-6 text-center text-sm text-gray-400">
                    Already have an account?{' '}
                    <Link href="/login" className="text-primary font-black hover:underline">
                        Log in
                    </Link>
                </div>
            </motion.div>
        </div>
    );
}

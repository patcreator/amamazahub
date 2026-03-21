import React from 'react';
import AppLayout from '../Components/AppLayout';
import { Head } from '@inertiajs/react';
import { CircleHelp, Search, MessageSquare, Shield, AlertTriangle, FileText, ChevronRight } from 'lucide-react';
import { motion } from 'framer-motion';

export default function HelpCenter() {
    const categories = [
        { title: 'Using AmazamaHub', icon: <Search className="text-primary" />, items: ['Create an account', 'Upload a video', 'Following & Followers'] },
        { title: 'Safety & Privacy', icon: <Shield className="text-blue-400" />, items: ['Privacy settings', 'Safety tools', 'Reporting a problem'] },
        { title: 'Creator Portal', icon: <MessageSquare className="text-green-400" />, items: ['Monetization', 'Copyright', 'LIVE streaming'] },
        { title: 'Account Issues', icon: <AlertTriangle className="text-red-400" />, items: ['Login help', 'Hacked accounts', 'Password reset'] },
    ];

    return (
        <AppLayout>
            <Head title="Help Center - AmazamaHub" />

            <div className="max-w-4xl mx-auto w-full py-12 px-4 pb-24 md:pb-12">
                <div className="text-center mb-16">
                    <h1 className="text-4xl font-black italic tracking-tighter mb-4">How can we help?</h1>
                    <div className="max-w-xl mx-auto relative group">
                        <Search className="absolute left-6 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-primary transition" size={20} />
                        <input
                            type="text"
                            placeholder="Search help articles..."
                            className="w-full bg-gray-900/50 border border-gray-800 rounded-full py-5 px-14 text-sm font-medium focus:outline-none focus:border-primary transition shadow-xl"
                        />
                    </div>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {categories.map((cat, i) => (
                        <div key={i} className="bg-gray-900/20 border border-gray-900 rounded-[32px] p-8 space-y-6">
                            <div className="flex items-center space-x-4">
                                <div className="p-3 bg-gray-800 rounded-2xl">{cat.icon}</div>
                                <h2 className="text-xl font-black italic">{cat.title}</h2>
                            </div>
                            <ul className="space-y-4">
                                {cat.items.map((item, j) => (
                                    <li key={j} className="flex items-center justify-between text-gray-400 hover:text-white cursor-pointer group transition">
                                        <span className="text-sm font-semibold">{item}</span>
                                        <ChevronRight size={16} className="text-gray-800 group-hover:text-primary transition" />
                                    </li>
                                ))}
                            </ul>
                        </div>
                    ))}
                </div>

                <div className="mt-20 p-10 bg-gradient-to-br from-primary/10 to-transparent border border-primary/10 rounded-[40px] flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
                    <div>
                        <h3 className="text-2xl font-black italic mb-2">Still need support?</h3>
                        <p className="text-gray-500 font-medium text-sm">Our team is available 24/7 to help you with any issues.</p>
                    </div>
                    <button className="bg-white text-black font-black px-10 py-4 rounded-2xl hover:scale-105 active:scale-95 transition shadow-lg">Contact Us</button>
                </div>
            </div>
        </AppLayout>
    );
}

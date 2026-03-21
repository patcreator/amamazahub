import React from 'react';
import AppLayout from '../Components/AppLayout';
import { Head, Link } from '@inertiajs/react';
import { User, Lock, Bell, Shield, Wallet, CircleHelp, Info, LogOut, ChevronRight, Moon, Globe, EyeOff, Clock, BookOpen, Settings2 } from 'lucide-react';
import { motion } from 'framer-motion';

export default function Settings() {
    const sections = [
        {
            title: 'Account',
            items: [
                { icon: <User size={20} />, label: 'Edit profile', href: '/profile/edit' },
                { icon: <Globe size={20} />, label: 'Language', detail: 'English' },
                { icon: <Wallet size={20} />, label: 'Balance', detail: '0 Coins' },
            ]
        },
        {
            title: 'Privacy & Safety',
            items: [
                { icon: <Lock size={20} />, label: 'Privacy Center', href: '/privacy' },
                { icon: <Shield size={20} />, label: 'Safety Center', href: '/safety' },
                { icon: <BookOpen size={20} />, label: 'Community Guidelines', href: '/guidelines' },
            ]
        },
        {
            title: 'Content & Activity',
            items: [
                { icon: <Clock size={20} />, label: 'Watch History', href: '/activity' },
                { icon: <Settings2 size={20} />, label: 'Content Preferences', href: '/preferences' },
                { icon: <Bell size={20} />, label: 'Push notifications' },
                { icon: <Moon size={20} />, label: 'Dark mode', detail: 'On' },
            ]
        },
        {
            title: 'Support',
            items: [
                { icon: <CircleHelp size={20} />, label: 'Help Center', href: '/help' },
                { icon: <Info size={20} />, label: 'Terms of Service' },
            ]
        }
    ];

    return (
        <AppLayout>
            <Head title="Settings - AmazamaHub" />

            <div className="max-w-2xl mx-auto w-full py-8 px-4 pb-24 md:pb-8">
                <h1 className="text-2xl font-black italic tracking-tighter mb-8 px-2">Settings and privacy</h1>

                <div className="space-y-8">
                    {sections.map((section, idx) => (
                        <div key={idx} className="space-y-2">
                            <p className="text-[10px] text-gray-500 font-black uppercase tracking-[0.2em] px-4">{section.title}</p>
                            <div className="bg-gray-900/30 rounded-3xl border border-white/5 overflow-hidden">
                                {section.items.map((item, i) => (
                                    <Link
                                        key={i}
                                        href={item.href || '#'}
                                        className="flex items-center justify-between p-4 hover:bg-white/5 transition border-b border-white/5 last:border-0 group"
                                    >
                                        <div className="flex items-center space-x-4">
                                            <div className="text-gray-400 group-hover:text-primary transition">
                                                {item.icon}
                                            </div>
                                            <span className="text-sm font-semibold text-gray-200">{item.label}</span>
                                        </div>
                                        <div className="flex items-center space-x-2">
                                            {item.detail && <span className="text-xs font-bold text-gray-500 italic">{item.detail}</span>}
                                            {item.toggle && (
                                                <div className="w-10 h-6 bg-primary/20 border border-primary/30 rounded-full relative">
                                                    <div className="absolute right-1 top-1 w-4 h-4 bg-primary rounded-full"></div>
                                                </div>
                                            )}
                                            {!item.toggle && <ChevronRight size={18} className="text-gray-700 group-hover:text-gray-500 transition" />}
                                        </div>
                                    </Link>
                                ))}
                            </div>
                        </div>
                    ))}

                    <div className="pt-6">
                        <Link
                            method="post"
                            as="button"
                            href="/logout"
                            className="w-full flex items-center justify-center space-x-2 p-4 bg-red-500/10 border border-red-500/20 text-red-500 rounded-2xl font-black italic hover:bg-red-500/20 transition"
                        >
                            <LogOut size={20} />
                            <span>Log out</span>
                        </Link>
                        <p className="text-center text-[10px] text-gray-600 font-black uppercase mt-10 tracking-widest leading-loose">
                            AmazamaHub v1.0.4<br />
                            Created with ❤️ for Creators
                        </p>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}

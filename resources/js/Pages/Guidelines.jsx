import React from 'react';
import AppLayout from '../Components/AppLayout';
import { Head } from '@inertiajs/react';
import { BookOpen, Scale, FileText, ShieldAlert, CheckCircle2, ChevronRight, MessageCircle } from 'lucide-react';
import { motion } from 'framer-motion';

export default function Guidelines() {
    return (
        <AppLayout>
            <Head title="Community Guidelines - AmazamaHub" />
            
            <div className="max-w-4xl mx-auto w-full py-12 px-4 pb-24 md:pb-12">
                <div className="flex flex-col items-center text-center mb-16 space-y-4">
                     <div className="bg-primary/20 p-4 rounded-3xl text-primary"><BookOpen size={40}/></div>
                     <h1 className="text-5xl font-black italic tracking-tighter leading-tight">Community Guidelines</h1>
                     <p className="text-gray-500 font-medium text-lg max-w-2xl italic">The principles that make AmazamaHub a place for everyone.</p>
                </div>

                <div className="space-y-12">
                     <section className="space-y-6">
                         <h2 className="text-xl font-black italic uppercase tracking-widest text-primary flex items-center space-x-3 px-4">
                             <div className="w-8 h-1 bg-primary rounded-full"></div>
                             <span>Our Core Values</span>
                         </h2>
                         <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                             {[
                                 { title: 'Inclusion', desc: 'We celebrate diverse voices and perspectives from all around the world.' },
                                 { title: 'Creativity', desc: 'Expression should be original, authentic, and inspiring.' },
                                 { title: 'Safety', desc: 'We have zero tolerance for hate speech or harassment.' },
                                 { title: 'Respect', desc: 'Treat every user with the same dignity you expect in return.' },
                             ].map((v, i) => (
                                 <div key={i} className="p-8 bg-gray-900/20 border border-gray-900 rounded-[40px] space-y-2">
                                     <p className="font-black italic text-lg">{v.title}</p>
                                     <p className="text-sm text-gray-500 font-medium leading-relaxed">{v.desc}</p>
                                 </div>
                             ))}
                         </div>
                     </section>

                     <section className="space-y-6">
                         <h2 className="text-xl font-black italic uppercase tracking-widest text-red-500 flex items-center space-x-3 px-4">
                             <div className="w-8 h-1 bg-red-500 rounded-full"></div>
                             <span>Safety Standards</span>
                         </h2>
                         <div className="bg-gray-900/10 border border-gray-900 rounded-[40px] overflow-hidden">
                             {[
                                 { title: 'Hate Speech & Harassment', icon: <ShieldAlert className="text-red-500"/> },
                                 { title: 'Violence & Sensitive Content', icon: <Scale className="text-orange-500"/> },
                                 { title: 'Spam & Deception', icon: <FileText className="text-blue-500"/> },
                             ].map((rule, i) => (
                                 <div key={i} className="flex items-center justify-between p-8 border-b border-gray-900 last:border-0 hover:bg-white/5 transition cursor-pointer group">
                                     <div className="flex items-center space-x-6">
                                         <div className="bg-gray-800 p-4 rounded-2xl group-hover:scale-110 transition">{rule.icon}</div>
                                         <div>
                                             <p className="font-black italic text-lg">{rule.title}</p>
                                             <p className="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1">Zero Tolerance Policy</p>
                                         </div>
                                     </div>
                                     <ChevronRight size={20} className="text-gray-800 group-hover:text-primary transition" />
                                 </div>
                             ))}
                         </div>
                     </section>

                     <div className="p-12 bg-gradient-to-br from-primary to-orange-600 rounded-[50px] text-center space-y-6 shadow-2xl shadow-primary/20">
                         <CheckCircle2 size={60} className="mx-auto text-black/20" />
                         <h3 className="text-3xl font-black italic text-black tracking-tighter">Help us stay safe</h3>
                         <p className="text-black font-bold max-w-sm mx-auto leading-relaxed">If you see something that violates these rules, please report it immediately.</p>
                         <button className="bg-black text-white font-black px-12 py-4 rounded-2xl hover:scale-105 transition shadow-xl mt-4">Report Now</button>
                     </div>
                </div>
            </div>
        </AppLayout>
    );
}

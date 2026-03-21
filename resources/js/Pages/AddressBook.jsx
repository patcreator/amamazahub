import React from 'react';
import AppLayout from '../Components/AppLayout';
import { Head, Link } from '@inertiajs/react';
import { MapPin, Plus, Home, Briefcase, Trash2, Edit2, ChevronRight, Check } from 'lucide-react';
import { motion } from 'framer-motion';

export default function AddressBook() {
    const addresses = [
        { id: 1, type: 'Home', name: 'John Doe', phone: '+1 234 567 890', address: '123 Amazama St, Digital City, 90210', isDefault: true },
        { id: 2, type: 'Work', name: 'John Doe', phone: '+1 234 567 890', address: '456 Creator Way, Tech Hub, 10001', isDefault: false },
    ];

    return (
        <AppLayout>
            <Head title="Address Book - AmazamaShop" />
            
            <div className="max-w-2xl mx-auto w-full py-8 px-4 pb-24 md:pb-8">
                <div className="flex items-center justify-between mb-10">
                    <h1 className="text-2xl font-black italic tracking-tighter">Shipping Addresses</h1>
                    <button className="p-2 bg-primary/10 border border-primary/20 rounded-full text-primary hover:bg-primary/20 transition"><Plus size={22} /></button>
                </div>

                <div className="space-y-6">
                    {addresses.map((addr) => (
                        <div key={addr.id} className={`bg-gray-900/20 border ${addr.isDefault ? 'border-primary/50' : 'border-gray-900'} rounded-[32px] p-8 space-y-4 relative overflow-hidden group transition`}>
                            <div className="flex items-center justify-between">
                                <div className="flex items-center space-x-3">
                                    <div className={`p-2 rounded-xl ${addr.isDefault ? 'bg-primary/20 text-primary' : 'bg-gray-800 text-gray-500'}`}>
                                        {addr.type === 'Home' ? <Home size={18}/> : <Briefcase size={18}/>}
                                    </div>
                                    <span className="text-sm font-black italic uppercase tracking-widest">{addr.type}</span>
                                    {addr.isDefault && <span className="text-[8px] font-black uppercase tracking-tighter bg-primary text-black px-2 py-0.5 rounded ml-2">Default</span>}
                                </div>
                                <div className="flex space-x-4 opacity-0 group-hover:opacity-100 transition duration-300">
                                    <button className="text-gray-500 hover:text-white transition"><Edit2 size={16}/></button>
                                    {!addr.isDefault && <button className="text-gray-500 hover:text-red-500 transition"><Trash2 size={16}/></button>}
                                </div>
                            </div>

                            <div className="space-y-2 pt-2">
                                <p className="font-bold text-gray-200">{addr.name}</p>
                                <p className="text-xs text-gray-500 font-medium">{addr.phone}</p>
                                <p className="text-xs text-gray-400 font-medium leading-relaxed">{addr.address}</p>
                            </div>

                            {!addr.isDefault && (
                                <button className="w-full mt-4 py-3 bg-gray-900 rounded-2xl text-[10px] font-black uppercase tracking-widest text-gray-600 hover:bg-gray-800 hover:text-white transition">
                                    Set as Default
                                </button>
                            )}
                        </div>
                    ))}
                </div>

                <div className="mt-12 p-8 bg-gray-950/40 border border-gray-900 rounded-[40px] flex items-start space-x-4">
                     <div className="p-3 bg-blue-500/10 rounded-2xl text-blue-400"><MapPin size={24}/></div>
                     <div className="space-y-1">
                         <p className="text-[10px] font-black italic tracking-widest uppercase text-gray-300">Privacy Notice</p>
                         <p className="text-[10px] text-gray-500 font-medium leading-relaxed">Your addresses are encrypted and used only for shipping purposes. We never share your personal details with third-party advertisers.</p>
                     </div>
                </div>
            </div>
        </AppLayout>
    );
}

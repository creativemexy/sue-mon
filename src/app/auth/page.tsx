"use client"

import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import CartSidebar from "@/components/CartSidebar";
import SearchModal from "@/components/SearchModal";
import Auth from "@/pages/Auth";

export default function AuthPage() {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <main>
        <Auth />
      </main>
      <Footer />
      <CartSidebar />
      <SearchModal />
    </div>
  );
} 
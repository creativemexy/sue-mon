"use client"

import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import CartSidebar from "@/components/CartSidebar";
import SearchModal from "@/components/SearchModal";
import Privacy from "@/pages/Privacy";

export default function PrivacyPage() {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <main>
        <Privacy />
      </main>
      <Footer />
      <CartSidebar />
      <SearchModal />
    </div>
  );
} 